<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class Module extends Model
{
    public function allForAdmin(): array
    {
        return $this->db()->query("SELECT m.ModuleID, m.ModuleName, m.ModuleLeaderID, m.Description, m.Image, m.ImageAlt,
                                          s.Name AS LeaderName
                                   FROM Modules m
                                   LEFT JOIN Staff s ON s.StaffID = m.ModuleLeaderID
                                   ORDER BY m.ModuleName")->fetchAll();
    }

    public function allSimple(): array
    {
        return $this->db()->query('SELECT ModuleID, ModuleName FROM Modules ORDER BY ModuleName')->fetchAll();
    }

    public function findById(int $id): array|false
    {
        $stmt = $this->db()->prepare('SELECT * FROM Modules WHERE ModuleID = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function save(array $data): void
    {
        $payload = [
            'name' => $data['module_name'],
            'leader_id' => $data['module_leader_id'] ?: null,
            'description' => $data['description'] ?: null,
            'image' => $data['image'] ?: null,
            'image_alt' => $data['image_alt'] ?: null,
        ];

        if ((int) $data['module_id'] > 0) {
            $payload['id'] = (int) $data['module_id'];
            $stmt = $this->db()->prepare("UPDATE Modules
                                          SET ModuleName = :name,
                                              ModuleLeaderID = :leader_id,
                                              Description = :description,
                                              Image = :image,
                                              ImageAlt = :image_alt
                                          WHERE ModuleID = :id");
            $stmt->execute($payload);
            return;
        }

        $stmt = $this->db()->prepare("INSERT INTO Modules
                                      (ModuleName, ModuleLeaderID, Description, Image, ImageAlt)
                                      VALUES (:name, :leader_id, :description, :image, :image_alt)");
        $stmt->execute($payload);
    }

    public function isAssigned(int $id): bool
    {
        $stmt = $this->db()->prepare('SELECT COUNT(*) FROM ProgrammeModules WHERE ModuleID = :id');
        $stmt->execute(['id' => $id]);
        return (int) $stmt->fetchColumn() > 0;
    }

    public function delete(int $id): void
    {
        $stmt = $this->db()->prepare('DELETE FROM Modules WHERE ModuleID = :id');
        $stmt->execute(['id' => $id]);
    }
}
