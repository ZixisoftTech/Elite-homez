<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use PDO;

class Feature extends Model {
    protected string $table = 'features';

    public function getActive(): array {
        $sql = "SELECT * FROM features WHERE status = 'active' ORDER BY sort_order ASC, name ASC";
        return $this->fetchAll($sql);
    }

    public function allOrdered(): array {
        $sql = "SELECT * FROM features ORDER BY sort_order ASC, name ASC";
        return $this->fetchAll($sql);
    }

    public function getByProperty(int $propertyId): array {
        $sql = "SELECT f.* FROM features f 
                JOIN property_features pf ON pf.feature_id = f.id 
                WHERE pf.property_id = :property_id AND f.status = 'active'
                ORDER BY f.sort_order ASC, f.name ASC";
        return $this->fetchAll($sql, ['property_id' => $propertyId]);
    }

    public function getPropertyFeatureIds(int $propertyId): array {
        $sql = "SELECT feature_id FROM property_features WHERE property_id = :property_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['property_id' => $propertyId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN) ?: [];
    }

    public function syncPropertyFeatures(int $propertyId, array $featureIds): void {
        // Clear existing associations
        $del = $this->db->prepare("DELETE FROM property_features WHERE property_id = :property_id");
        $del->execute(['property_id' => $propertyId]);

        if (empty($featureIds)) {
            return;
        }

        $ins = $this->db->prepare("INSERT INTO property_features (property_id, feature_id) VALUES (:property_id, :feature_id)");
        foreach ($featureIds as $fId) {
            $fId = (int) $fId;
            if ($fId > 0) {
                $ins->execute(['property_id' => $propertyId, 'feature_id' => $fId]);
            }
        }
    }

    public function isFeatureInUse(int $featureId): bool {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM property_features WHERE feature_id = :id");
        $stmt->execute(['id' => $featureId]);
        return ((int) $stmt->fetchColumn()) > 0;
    }
}
