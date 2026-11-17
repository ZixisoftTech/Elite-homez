<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class Service extends Model {
    protected string $table = 'services';

    public function getPublished(): array {
        $sql = "SELECT * FROM services WHERE is_published = 1 ORDER BY sort_order ASC, name ASC";
        return $this->fetchAll($sql);
    }

    public function getHomeServices(int $limit = 6): array {
        $sql = "SELECT * FROM services WHERE is_published = 1 AND show_on_home = 1 ORDER BY sort_order ASC, name ASC LIMIT {$limit}";
        $res = $this->fetchAll($sql);
        if (empty($res)) {
            // Fallback to published services if none tagged
            return $this->fetchAll("SELECT * FROM services WHERE is_published = 1 ORDER BY sort_order ASC, name ASC LIMIT {$limit}");
        }
        return $res;
    }

    public function toggleShowOnHome(int $id): bool {
        $service = $this->find($id);
        if (!$service) {
            return false;
        }
        $newVal = !empty($service['show_on_home']) ? 0 : 1;
        return $this->update($id, ['show_on_home' => $newVal]);
    }

    public function toggleStatus(int $id): bool {
        $service = $this->find($id);
        if (!$service) {
            return false;
        }
        $newVal = !empty($service['is_published']) ? 0 : 1;
        return $this->update($id, ['is_published' => $newVal]);
    }
}
