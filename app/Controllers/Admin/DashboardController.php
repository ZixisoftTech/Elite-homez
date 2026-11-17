<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Area;
use App\Models\Enquiry;
use App\Models\Feature;
use App\Models\Property;
use App\Models\Service;

class DashboardController extends Controller {
    public function index(): void {
        $this->requireAuth();

        $propertyModel = new Property();
        $areaModel = new Area();
        $serviceModel = new Service();
        $enquiryModel = new Enquiry();
        $featureModel = new Feature();

        $stats = [
            'total_properties' => $propertyModel->count(),
            'published_properties' => $propertyModel->count("status = 'published'"),
            'total_enquiries' => $enquiryModel->count(),
            'new_enquiries' => $enquiryModel->countNew(),
            'total_areas' => $areaModel->count(),
            'total_services' => $serviceModel->count(),
            'total_features' => $featureModel->count()
        ];

        $recentEnquiries = $enquiryModel->getRecent(6);

        $this->renderAdmin('admin/dashboard/index', [
            'stats' => $stats,
            'recentEnquiries' => $recentEnquiries,
            'seo' => ['title' => 'Executive Dashboard | Elite Homez Admin']
        ]);
    }
}
