<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Helpers\Csrf;
use App\Helpers\Format;
use App\Helpers\Session;
use App\Helpers\Uploader;
use App\Models\Area;
use App\Models\Feature;
use App\Models\Property;
use App\Models\PropertyImage;

class PropertyAdminController extends Controller {
    public function index(): void {
        $this->requireAuth();
        $propertyModel = new Property();
        $allProps = $propertyModel->allWithArea();

        $filter = strtolower((string) $this->request->get('filter', 'all'));
        $properties = match ($filter) {
            'sale' => array_values(array_filter($allProps, fn($p) => ($p['listing_type'] ?? '') === 'sale')),
            'rent' => array_values(array_filter($allProps, fn($p) => ($p['listing_type'] ?? '') === 'rent')),
            'featured' => array_values(array_filter($allProps, fn($p) => !empty($p['is_featured']))),
            default => $allProps
        };

        $counts = [
            'all' => count($allProps),
            'sale' => count(array_filter($allProps, fn($p) => ($p['listing_type'] ?? '') === 'sale')),
            'rent' => count(array_filter($allProps, fn($p) => ($p['listing_type'] ?? '') === 'rent')),
            'featured' => count(array_filter($allProps, fn($p) => !empty($p['is_featured'])))
        ];

        $this->renderAdmin('admin/properties/index', [
            'properties' => $properties,
            'currentFilter' => $filter,
            'counts' => $counts,
            'seo' => ['title' => 'Property Portfolio Management | Elite Homez']
        ]);
    }

    public function create(): void {
        $this->requireAuth();
        $areaModel = new Area();
        $featureModel = new Feature();

        $areas = $areaModel->getPublished();
        $features = $featureModel->getActive();

        $this->renderAdmin('admin/properties/create', [
            'areas' => $areas,
            'features' => $features,
            'seo' => ['title' => 'Add Luxury Property | Elite Homez']
        ]);
    }

    public function store(): void {
        $this->requireAuth();
        $token = (string) $this->request->post('csrf_token', '');
        if (!Csrf::validate($token)) {
            Session::setFlash('error', 'CSRF security token invalid.');
            $this->redirect('/admin/properties/create');
            return;
        }

        $title = trim((string) $this->request->post('title', ''));
        $areaId = (int) $this->request->post('area_id', 0);
        $propertyType = trim((string) $this->request->post('property_type', 'Independent Villa'));
        $listingType = in_array($this->request->post('listing_type'), ['sale', 'rent']) ? $this->request->post('listing_type') : 'sale';
        $price = (float) $this->request->post('price', 0);
        $priceDisplay = trim((string) $this->request->post('price_display', ''));
        $propertyLocation = trim((string) $this->request->post('property_location', ''));
        $googleMapUrl = trim((string) $this->request->post('google_map_url', ''));
        $description = trim((string) $this->request->post('description', ''));
        $propertySize = trim((string) $this->request->post('property_size', ''));
        $plotSize = trim((string) $this->request->post('plot_size', ''));
        $bedrooms = (int) $this->request->post('bedrooms', 0);
        $bathrooms = (int) $this->request->post('bathrooms', 0);
        $parking = (int) $this->request->post('parking_spaces', 0);
        $floorInfo = trim((string) $this->request->post('floor_info', ''));
        $isFeatured = $this->request->post('is_featured') ? 1 : 0;
        $status = in_array($this->request->post('status'), ['published', 'draft', 'archived']) ? $this->request->post('status') : 'published';
        $sortOrder = (int) $this->request->post('sort_order', 0);
        $seoTitle = trim((string) $this->request->post('seo_title', ''));
        $metaDesc = trim((string) $this->request->post('meta_description', ''));

        if (empty($title) || $areaId <= 0 || empty($propertyLocation) || empty($description)) {
            Session::setFlash('error', 'Please fill in all mandatory fields (Title, Area, Location, Description).');
            $this->redirect('/admin/properties/create');
            return;
        }

        if (empty($priceDisplay)) {
            $priceDisplay = Format::price($price, $listingType);
        }

        $slug = Format::slug($title);
        $propertyModel = new Property();
        if ($propertyModel->findBySlug($slug)) {
            $slug .= '-' . rand(100, 999);
        }

        // Handle Primary Featured Image Upload
        $directFeatured = trim((string) ($this->request->post('featured_image_url') ?: $this->request->post('featured_image_path') ?: ''));
        $featuredImagePath = !empty($directFeatured) ? $directFeatured : '/assets/images/hero/hero-main.jpg'; // fallback
        $file = $this->request->file('featured_image');
        if ($file && isset($file['error']) && $file['error'] !== UPLOAD_ERR_NO_FILE) {
            $upload = Uploader::uploadImage($file, 'properties');
            if ($upload['success']) {
                $featuredImagePath = $upload['url'];
            } else {
                Session::setFlash('error', 'Featured image upload failed: ' . $upload['message']);
                $this->redirect('/admin/properties/create');
                return;
            }
        }

        $mandateRef = trim((string) $this->request->post('mandate_ref', ''));
        $reraNumber = trim((string) $this->request->post('rera_number', 'DLRERA2023A00892'));
        $subTitle = trim((string) $this->request->post('sub_title', ''));
        $orientation = trim((string) $this->request->post('orientation', ''));
        $ceilingHeight = trim((string) $this->request->post('ceiling_height', ''));
        $architectInfo = trim((string) $this->request->post('architect_info', ''));
        $coordinates = trim((string) $this->request->post('coordinates', ''));
        $provenanceQuote = trim((string) $this->request->post('provenance_quote', ''));
        $lifestyleQuote = trim((string) $this->request->post('lifestyle_quote', ''));

        $propId = $propertyModel->create([
            'area_id' => $areaId,
            'title' => $title,
            'sub_title' => $subTitle,
            'slug' => $slug,
            'mandate_ref' => $mandateRef,
            'rera_number' => $reraNumber,
            'property_type' => $propertyType,
            'listing_type' => $listingType,
            'price' => $price,
            'price_display' => $priceDisplay,
            'property_size' => $propertySize,
            'plot_size' => $plotSize,
            'bedrooms' => $bedrooms,
            'bathrooms' => $bathrooms,
            'parking_spaces' => $parking,
            'floor_info' => $floorInfo,
            'orientation' => $orientation,
            'ceiling_height' => $ceilingHeight,
            'architect_info' => $architectInfo,
            'property_location' => $propertyLocation,
            'google_map_url' => $googleMapUrl,
            'coordinates' => $coordinates,
            'description' => $description,
            'provenance_quote' => $provenanceQuote,
            'lifestyle_quote' => $lifestyleQuote,
            'featured_image' => $featuredImagePath,
            'is_featured' => $isFeatured,
            'status' => $status,
            'sort_order' => $sortOrder,
            'seo_title' => $seoTitle ?: "{$title} | Elite Homez",
            'meta_description' => $metaDesc ?: substr(strip_tags($description), 0, 160)
        ]);

        // Sync Master Features Checkboxes
        $selectedFeatures = (array) ($this->request->post('features') ?? []);
        $featureModel = new Feature();
        $featureModel->syncPropertyFeatures($propId, $selectedFeatures);

        // Handle Additional Gallery Images Upload
        $this->handleGalleryUploads($propId);

        Session::setFlash('success', "Property '{$title}' created successfully.");
        $this->redirect('/admin/properties');
    }

    public function edit(string $id): void {
        $this->requireAuth();
        $propertyModel = new Property();
        $areaModel = new Area();
        $featureModel = new Feature();
        $imageModel = new PropertyImage();

        $property = $propertyModel->find((int) $id);
        if (!$property) {
            Session::setFlash('error', 'Property not found.');
            $this->redirect('/admin/properties');
            return;
        }

        $areas = $areaModel->getPublished();
        $features = $featureModel->getActive();
        $selectedFeatureIds = $featureModel->getPropertyFeatureIds((int) $id);
        $galleryImages = $imageModel->getByProperty((int) $id);

        $this->renderAdmin('admin/properties/edit', [
            'property' => $property,
            'areas' => $areas,
            'features' => $features,
            'selectedFeatureIds' => $selectedFeatureIds,
            'galleryImages' => $galleryImages,
            'seo' => ['title' => "Edit {$property['title']} | Elite Homez Admin"]
        ]);
    }

    public function update(string $id): void {
        $this->requireAuth();
        $token = (string) $this->request->post('csrf_token', '');
        if (!Csrf::validate($token)) {
            Session::setFlash('error', 'CSRF security token invalid.');
            $this->redirect("/admin/properties/edit/{$id}");
            return;
        }

        $propertyModel = new Property();
        $property = $propertyModel->find((int) $id);
        if (!$property) {
            Session::setFlash('error', 'Property not found.');
            $this->redirect('/admin/properties');
            return;
        }

        $title = trim((string) $this->request->post('title', ''));
        $areaId = (int) $this->request->post('area_id', 0);
        $propertyType = trim((string) $this->request->post('property_type', 'Independent Villa'));
        $listingType = in_array($this->request->post('listing_type'), ['sale', 'rent']) ? $this->request->post('listing_type') : 'sale';
        $price = (float) $this->request->post('price', 0);
        $priceDisplay = trim((string) $this->request->post('price_display', ''));
        $propertyLocation = trim((string) $this->request->post('property_location', ''));
        $googleMapUrl = trim((string) $this->request->post('google_map_url', ''));
        $description = trim((string) $this->request->post('description', ''));
        $propertySize = trim((string) $this->request->post('property_size', ''));
        $plotSize = trim((string) $this->request->post('plot_size', ''));
        $bedrooms = (int) $this->request->post('bedrooms', 0);
        $bathrooms = (int) $this->request->post('bathrooms', 0);
        $parking = (int) $this->request->post('parking_spaces', 0);
        $floorInfo = trim((string) $this->request->post('floor_info', ''));
        $isFeatured = $this->request->post('is_featured') ? 1 : 0;
        $status = in_array($this->request->post('status'), ['published', 'draft', 'archived']) ? $this->request->post('status') : 'published';
        $sortOrder = (int) $this->request->post('sort_order', 0);
        $seoTitle = trim((string) $this->request->post('seo_title', ''));
        $metaDesc = trim((string) $this->request->post('meta_description', ''));

        if (empty($title) || $areaId <= 0 || empty($propertyLocation)) {
            Session::setFlash('error', 'Title, Area, and Location are mandatory.');
            $this->redirect("/admin/properties/edit/{$id}");
            return;
        }

        if (empty($priceDisplay)) {
            $priceDisplay = Format::price($price, $listingType);
        }

        $directFeatured = trim((string) ($this->request->post('featured_image_url') ?: $this->request->post('featured_image_path') ?: ''));
        $featuredImagePath = !empty($directFeatured) ? $directFeatured : (!empty($property['featured_image']) ? $property['featured_image'] : '/assets/images/hero/hero-main.jpg');
        $file = $this->request->file('featured_image');
        if ($file && isset($file['error']) && $file['error'] !== UPLOAD_ERR_NO_FILE) {
            $upload = Uploader::uploadImage($file, 'properties');
            if ($upload['success']) {
                $featuredImagePath = $upload['url'];
            } else {
                Session::setFlash('error', 'Featured image upload failed: ' . $upload['message']);
                $this->redirect("/admin/properties/edit/{$id}");
                return;
            }
        }

        $mandateRef = trim((string) $this->request->post('mandate_ref', ''));
        $reraNumber = trim((string) $this->request->post('rera_number', 'DLRERA2023A00892'));
        $subTitle = trim((string) $this->request->post('sub_title', ''));
        $orientation = trim((string) $this->request->post('orientation', ''));
        $ceilingHeight = trim((string) $this->request->post('ceiling_height', ''));
        $architectInfo = trim((string) $this->request->post('architect_info', ''));
        $coordinates = trim((string) $this->request->post('coordinates', ''));
        $provenanceQuote = trim((string) $this->request->post('provenance_quote', ''));
        $lifestyleQuote = trim((string) $this->request->post('lifestyle_quote', ''));

        $propertyModel->update((int) $id, [
            'area_id' => $areaId,
            'title' => $title,
            'sub_title' => $subTitle,
            'mandate_ref' => $mandateRef,
            'rera_number' => $reraNumber,
            'property_type' => $propertyType,
            'listing_type' => $listingType,
            'price' => $price,
            'price_display' => $priceDisplay,
            'property_size' => $propertySize,
            'plot_size' => $plotSize,
            'bedrooms' => $bedrooms,
            'bathrooms' => $bathrooms,
            'parking_spaces' => $parking,
            'floor_info' => $floorInfo,
            'orientation' => $orientation,
            'ceiling_height' => $ceilingHeight,
            'architect_info' => $architectInfo,
            'property_location' => $propertyLocation,
            'google_map_url' => $googleMapUrl,
            'coordinates' => $coordinates,
            'description' => $description,
            'provenance_quote' => $provenanceQuote,
            'lifestyle_quote' => $lifestyleQuote,
            'featured_image' => $featuredImagePath,
            'is_featured' => $isFeatured,
            'status' => $status,
            'sort_order' => $sortOrder,
            'seo_title' => $seoTitle ?: "{$title} | Elite Homez",
            'meta_description' => $metaDesc ?: substr(strip_tags($description), 0, 160)
        ]);

        // Sync Features Checkboxes
        $selectedFeatures = (array) ($this->request->post('features') ?? []);
        $featureModel = new Feature();
        $featureModel->syncPropertyFeatures((int) $id, $selectedFeatures);

        // Handle Additional Gallery Uploads
        $this->handleGalleryUploads((int) $id);

        Session::setFlash('success', "Property '{$title}' updated successfully.");
        $this->redirect("/admin/properties/edit/{$id}");
    }

    public function toggleFeatured(string $id): void {
        $this->requireAuth();
        $token = (string) $this->request->post('csrf_token', '');
        if (!Csrf::validate($token)) {
            Session::setFlash('error', 'CSRF validation failed.');
            $this->redirect('/admin/properties');
            return;
        }

        $propertyModel = new Property();
        $propertyModel->toggleFeatured((int) $id);
        Session::setFlash('success', 'Featured status updated.');
        $this->redirect('/admin/properties');
    }

    public function toggleStatus(string $id): void {
        $this->requireAuth();
        $token = (string) $this->request->post('csrf_token', '');
        if (!Csrf::validate($token)) {
            Session::setFlash('error', 'CSRF validation failed.');
            $this->redirect('/admin/properties');
            return;
        }

        $propertyModel = new Property();
        $propertyModel->toggleStatus((int) $id);
        Session::setFlash('success', 'Property listing visibility status toggled.');
        $this->redirect('/admin/properties');
    }

    public function delete(string $id): void {
        $this->requireAuth();
        $token = (string) $this->request->post('csrf_token', '');
        if (!Csrf::validate($token)) {
            Session::setFlash('error', 'CSRF validation failed.');
            $this->redirect('/admin/properties');
            return;
        }

        $propertyModel = new Property();
        $propertyModel->delete((int) $id);
        Session::setFlash('success', 'Property listing removed.');
        $this->redirect('/admin/properties');
    }

    public function deleteImage(string $id): void {
        $this->requireAuth();
        $token = (string) $this->request->post('csrf_token', '');
        if (!Csrf::validate($token)) {
            Session::setFlash('error', 'CSRF validation failed.');
            $this->redirect('/admin/properties');
            return;
        }

        $imageModel = new PropertyImage();
        $img = $imageModel->find((int) $id);
        if ($img) {
            $propertyId = $img['property_id'];
            $imageModel->delete((int) $id);
            Session::setFlash('success', 'Gallery image deleted.');
            $this->redirect("/admin/properties/edit/{$propertyId}");
            return;
        }

        $this->redirect('/admin/properties');
    }

    private function handleGalleryUploads(int $propertyId): void {
        $galleryFiles = $_FILES['gallery_images'] ?? null;
        if (!$galleryFiles || !is_array($galleryFiles['name'])) {
            return;
        }

        $imageModel = new PropertyImage();
        $count = count($galleryFiles['name']);

        for ($i = 0; $i < $count; $i++) {
            if ($galleryFiles['error'][$i] === UPLOAD_ERR_OK) {
                $fileItem = [
                    'name' => $galleryFiles['name'][$i],
                    'type' => $galleryFiles['type'][$i],
                    'tmp_name' => $galleryFiles['tmp_name'][$i],
                    'error' => $galleryFiles['error'][$i],
                    'size' => $galleryFiles['size'][$i],
                ];
                $upload = Uploader::uploadImage($fileItem, 'properties');
                if ($upload['success']) {
                    $imageModel->add($propertyId, $upload['url'], '', $i + 1, 0);
                }
            }
        }
    }
}
