<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class Enquiry extends Model {
    protected string $table = 'enquiries';

    public function allWithContext(string $status = ''): array {
        $sql = "SELECT e.*, p.title as property_title, p.slug as property_slug, a.name as area_name 
                FROM enquiries e 
                LEFT JOIN properties p ON p.id = e.property_id 
                LEFT JOIN areas a ON a.id = e.area_id";

        $params = [];
        if ($status !== '' && in_array($status, ['new', 'contacted', 'qualified', 'closed', 'spam'], true)) {
            $sql .= " WHERE e.status = :status";
            $params['status'] = $status;
        }

        $sql .= " ORDER BY e.id DESC";
        return $this->fetchAll($sql, $params);
    }

    public function getRecent(int $limit = 5): array {
        $sql = "SELECT e.*, p.title as property_title, a.name as area_name 
                FROM enquiries e 
                LEFT JOIN properties p ON p.id = e.property_id 
                LEFT JOIN areas a ON a.id = e.area_id 
                ORDER BY e.id DESC 
                LIMIT :lim";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':lim', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function countNew(): int {
        return $this->count("status = 'new'");
    }

    public function updateStatus(int $id, string $status): bool {
        if (!in_array($status, ['new', 'contacted', 'qualified', 'closed', 'spam'], true)) {
            return false;
        }
        return $this->update($id, ['status' => $status]);
    }
}
