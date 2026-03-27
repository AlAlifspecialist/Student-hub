<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class Programme extends Model
{
    public function searchPublished(string $search = '', string $level = ''): array
    {
        $sql = "SELECT p.ProgrammeID, p.ProgrammeName, p.Description, p.Image, p.ImageAlt, p.IsPublished,
                       l.LevelName,
                       s.Name AS ProgrammeLeaderName,
                       s.JobTitle AS ProgrammeLeaderTitle
                FROM Programmes p
                LEFT JOIN Levels l ON l.LevelID = p.LevelID
                LEFT JOIN Staff s ON s.StaffID = p.ProgrammeLeaderID
                WHERE p.IsPublished = 1";

        $params = [];
        if ($search !== '') {
            $sql .= ' AND (p.ProgrammeName LIKE :search OR p.Description LIKE :search)';
            $params['search'] = '%' . $search . '%';
        }
        if ($level !== '') {
            $sql .= ' AND l.LevelName = :level';
            $params['level'] = $level;
        }
        $sql .= ' ORDER BY l.LevelName, p.ProgrammeName';

        $stmt = $this->db()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function findPublishedById(int $id): array|false
    {
        $stmt = $this->db()->prepare("SELECT p.*, l.LevelName,
                                             s.Name AS ProgrammeLeaderName, s.JobTitle, s.Department, s.Bio, s.Photo
                                      FROM Programmes p
                                      LEFT JOIN Levels l ON l.LevelID = p.LevelID
                                      LEFT JOIN Staff s ON s.StaffID = p.ProgrammeLeaderID
                                      WHERE p.ProgrammeID = :id AND p.IsPublished = 1");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function modulesGroupedByYear(int $programmeId): array
    {
        $stmt = $this->db()->prepare("SELECT pm.Year, m.ModuleID, m.ModuleName, m.Description, m.Image, m.ImageAlt,
                                             st.Name AS ModuleLeaderName, st.JobTitle AS ModuleLeaderTitle,
                                             (
                                                SELECT COUNT(DISTINCT pm2.ProgrammeID)
                                                FROM ProgrammeModules pm2
                                                WHERE pm2.ModuleID = m.ModuleID
                                             ) AS SharedProgrammeCount
                                      FROM ProgrammeModules pm
                                      INNER JOIN Modules m ON m.ModuleID = pm.ModuleID
                                      LEFT JOIN Staff st ON st.StaffID = m.ModuleLeaderID
                                      WHERE pm.ProgrammeID = :id
                                      ORDER BY pm.Year, m.ModuleName");
        $stmt->execute(['id' => $programmeId]);
        $rows = $stmt->fetchAll();

        $grouped = [];
        foreach ($rows as $row) {
            $grouped[$row['Year']][] = $row;
        }
        return $grouped;
    }

    public function allForAdmin(): array
    {
        return $this->db()->query("SELECT p.ProgrammeID, p.ProgrammeName, p.LevelID, p.ProgrammeLeaderID, p.Description,
                                          p.Image, p.ImageAlt, p.IsPublished, l.LevelName, s.Name AS LeaderName
                                   FROM Programmes p
                                   LEFT JOIN Levels l ON l.LevelID = p.LevelID
                                   LEFT JOIN Staff s ON s.StaffID = p.ProgrammeLeaderID
                                   ORDER BY l.LevelName, p.ProgrammeName")->fetchAll();
    }

    public function allSimple(): array
    {
        return $this->db()->query('SELECT ProgrammeID, ProgrammeName FROM Programmes ORDER BY ProgrammeName')->fetchAll();
    }

    public function findById(int $id): array|false
    {
        $stmt = $this->db()->prepare('SELECT * FROM Programmes WHERE ProgrammeID = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function save(array $data): void
    {
        $payload = [
            'name' => $data['programme_name'],
            'level_id' => $data['level_id'],
            'leader_id' => $data['programme_leader_id'] ?: null,
            'description' => $data['description'] ?: null,
            'image' => $data['image'] ?: null,
            'image_alt' => $data['image_alt'] ?: null,
            'is_published' => $data['is_published'],
        ];

        if ((int) $data['programme_id'] > 0) {
            $payload['id'] = (int) $data['programme_id'];
            $stmt = $this->db()->prepare("UPDATE Programmes
                                          SET ProgrammeName = :name,
                                              LevelID = :level_id,
                                              ProgrammeLeaderID = :leader_id,
                                              Description = :description,
                                              Image = :image,
                                              ImageAlt = :image_alt,
                                              IsPublished = :is_published
                                          WHERE ProgrammeID = :id");
            $stmt->execute($payload);
            return;
        }

        $stmt = $this->db()->prepare("INSERT INTO Programmes
                                      (ProgrammeName, LevelID, ProgrammeLeaderID, Description, Image, ImageAlt, IsPublished)
                                      VALUES (:name, :level_id, :leader_id, :description, :image, :image_alt, :is_published)");
        $stmt->execute($payload);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db()->prepare('DELETE FROM Programmes WHERE ProgrammeID = :id');
        $stmt->execute(['id' => $id]);
    }
}
