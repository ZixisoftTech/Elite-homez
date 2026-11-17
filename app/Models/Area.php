<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class Area extends Model {
    protected string $table = 'areas';

    public function getPublished(): array {
        $sql = "SELECT * FROM areas WHERE is_published = 1 ORDER BY sort_order ASC, name ASC";
        return $this->fetchAll($sql);
    }

    public function getPublishedWithCount(): array {
        $sql = "SELECT a.*, COUNT(p.id) as property_count 
                FROM areas a 
                LEFT JOIN properties p ON p.area_id = a.id AND p.status = 'published'
                WHERE a.is_published = 1
                GROUP BY a.id 
                ORDER BY a.sort_order ASC, a.name ASC";
        return $this->fetchAll($sql);
    }

    public function allWithCount(): array {
        $sql = "SELECT a.*, COUNT(p.id) as property_count 
                FROM areas a 
                LEFT JOIN properties p ON p.area_id = a.id AND p.status = 'published'
                GROUP BY a.id 
                ORDER BY a.sort_order ASC, a.name ASC";
        return $this->fetchAll($sql);
    }

    public function getProperties(int $areaId): array {
        $sql = "SELECT p.*, a.name as area_name 
                FROM properties p 
                JOIN areas a ON a.id = p.area_id 
                WHERE p.area_id = :area_id AND p.status = 'published' 
                ORDER BY p.is_featured DESC, p.sort_order ASC, p.id DESC";
        return $this->fetchAll($sql, ['area_id' => $areaId]);
    }

    public function getHomeAreas(int $limit = 8): array {
        $sql = "SELECT a.*, COUNT(p.id) as property_count 
                FROM areas a 
                LEFT JOIN properties p ON p.area_id = a.id AND p.status = 'published'
                WHERE a.is_published = 1 AND a.show_on_home = 1
                GROUP BY a.id 
                ORDER BY a.sort_order ASC, a.name ASC 
                LIMIT {$limit}";
        $res = $this->fetchAll($sql);
        if (empty($res)) {
            // Fallback to published areas
            return $this->fetchAll("SELECT a.*, COUNT(p.id) as property_count FROM areas a LEFT JOIN properties p ON p.area_id = a.id AND p.status = 'published' WHERE a.is_published = 1 GROUP BY a.id ORDER BY a.sort_order ASC, a.name ASC LIMIT {$limit}");
        }
        return $res;
    }

    public function toggleShowOnHome(int $id): bool {
        $area = $this->find($id);
        if (!$area) {
            return false;
        }
        $newVal = !empty($area['show_on_home']) ? 0 : 1;
        return $this->update($id, ['show_on_home' => $newVal]);
    }

    public function toggleStatus(int $id): bool {
        $area = $this->find($id);
        if (!$area) {
            return false;
        }
        $newVal = !empty($area['is_published']) ? 0 : 1;
        return $this->update($id, ['is_published' => $newVal]);
    }
}
