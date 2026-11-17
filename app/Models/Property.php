<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class Property extends Model {
    protected string $table = 'properties';

    public function getFeatured(?int $limit = null): array {
        $sql = "SELECT p.*, a.name as area_name, a.slug as area_slug 
                FROM properties p 
                JOIN areas a ON a.id = p.area_id 
                WHERE p.is_featured = 1 AND p.status = 'published' 
                ORDER BY p.sort_order ASC, p.id DESC";
        if ($limit !== null && $limit > 0) {
            $sql .= " LIMIT :lim";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':lim', $limit, \PDO::PARAM_INT);
        } else {
            $stmt = $this->db->prepare($sql);
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getCatalogue(
        string $type = 'all', 
        ?string $areaSlug = null, 
        ?string $category = null,
        ?string $search = null,
        ?string $priceRange = null,
        string $sort = 'featured'
    ): array {
        $sql = "SELECT p.*, a.name as area_name, a.slug as area_slug 
                FROM properties p 
                JOIN areas a ON a.id = p.area_id 
                WHERE p.status = 'published'";

        $params = [];
        if ($type === 'sale' || $type === 'rent') {
            $sql .= " AND p.listing_type = :ltype";
            $params['ltype'] = $type;
        }

        if (!empty($areaSlug) && $areaSlug !== 'all') {
            $sql .= " AND a.slug = :aslug";
            $params['aslug'] = $areaSlug;
        }

        if (!empty($category) && $category !== 'all') {
            if ($category === 'bungalow') {
                $sql .= " AND (p.property_type LIKE '%Bungalow%' OR p.property_type LIKE '%Villa%' OR p.property_type LIKE '%Estate%' OR p.property_type LIKE '%House%')";
            } elseif ($category === 'floor') {
                $sql .= " AND (p.property_type LIKE '%Floor%')";
            } elseif ($category === 'penthouse') {
                $sql .= " AND (p.property_type LIKE '%Penthouse%' OR p.property_type LIKE '%Duplex%')";
            } else {
                $sql .= " AND (p.property_type LIKE :cat OR p.title LIKE :cattitle)";
                $params['cat'] = '%' . $category . '%';
                $params['cattitle'] = '%' . $category . '%';
            }
        }

        if (!empty($search)) {
            $sql .= " AND (p.title LIKE :search OR p.property_location LIKE :search OR p.sub_title LIKE :search OR p.mandate_ref LIKE :search OR a.name LIKE :search)";
            $params['search'] = '%' . $search . '%';
        }

        if (!empty($priceRange) && $priceRange !== 'all') {
            if ($priceRange === 'under-25') {
                $sql .= " AND p.price < 250000000";
            } elseif ($priceRange === '25-50') {
                $sql .= " AND p.price >= 250000000 AND p.price <= 500000000";
            } elseif ($priceRange === '50-plus') {
                $sql .= " AND p.price > 500000000";
            } elseif ($priceRange === 'rent-under-5') {
                $sql .= " AND p.price < 500000";
            } elseif ($priceRange === 'rent-5-10') {
                $sql .= " AND p.price >= 500000 AND p.price <= 1000000";
            } elseif ($priceRange === 'rent-10-plus') {
                $sql .= " AND p.price > 1000000";
            }
        }

        // Sorting
        switch ($sort) {
            case 'price_desc':
                $sql .= " ORDER BY p.price DESC, p.id DESC";
                break;
            case 'price_asc':
                $sql .= " ORDER BY p.price ASC, p.id DESC";
                break;
            case 'newest':
                $sql .= " ORDER BY p.id DESC";
                break;
            case 'featured':
            default:
                $sql .= " ORDER BY p.is_featured DESC, p.sort_order ASC, p.id DESC";
                break;
        }

        return $this->fetchAll($sql, $params);
    }

    public function findBySlugWithDetails(string $slug): ?array {
        $sql = "SELECT p.*, a.name as area_name, a.slug as area_slug, a.map_url as area_map_url 
                FROM properties p 
                JOIN areas a ON a.id = p.area_id 
                WHERE p.slug = :slug LIMIT 1";
        return $this->fetchOne($sql, ['slug' => $slug]);
    }

    public function getSimilar(int $currentId, int $areaId, int $limit = 3): array {
        $sql = "SELECT p.*, a.name as area_name 
                FROM properties p 
                JOIN areas a ON a.id = p.area_id 
                WHERE p.id != :cid AND p.status = 'published' 
                ORDER BY (p.area_id = :aid) DESC, p.is_featured DESC, p.id DESC 
                LIMIT :lim";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':cid', $currentId, \PDO::PARAM_INT);
        $stmt->bindValue(':aid', $areaId, \PDO::PARAM_INT);
        $stmt->bindValue(':lim', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function allWithArea(): array {
        $sql = "SELECT p.*, a.name as area_name 
                FROM properties p 
                JOIN areas a ON a.id = p.area_id 
                ORDER BY p.id DESC";
        return $this->fetchAll($sql);
    }

    public function toggleFeatured(int $id): bool {
        $sql = "UPDATE properties SET is_featured = (1 - is_featured) WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    public function toggleStatus(int $id): bool {
        $sql = "UPDATE properties SET status = CASE WHEN status = 'published' THEN 'draft' ELSE 'published' END WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    public function getCatalogueCounts(): array {
        $sql = "SELECT 
                    COUNT(*) as total_count,
                    COALESCE(SUM(CASE WHEN listing_type = 'sale' THEN 1 ELSE 0 END), 0) as sale_count,
                    COALESCE(SUM(CASE WHEN listing_type = 'rent' THEN 1 ELSE 0 END), 0) as rent_count
                FROM properties 
                WHERE status = 'published'";
        $row = $this->fetchOne($sql);
        return [
            'all' => (int) ($row['total_count'] ?? 0),
            'sale' => (int) ($row['sale_count'] ?? 0),
            'rent' => (int) ($row['rent_count'] ?? 0),
        ];
    }
}
