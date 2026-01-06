<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260105143534 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE hall (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, total_rows INT NOT NULL, seats_per_row INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movie (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, duration_minutes INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, screening_id INT NOT NULL, customer_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_42C8495570F5295D (screening_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation_seat (id INT AUTO_INCREMENT NOT NULL, reservation_id INT NOT NULL, screening_id INT NOT NULL, `row_number` INT NOT NULL, seat_number INT NOT NULL, INDEX IDX_2B65FB0EB83297E7 (reservation_id), INDEX IDX_2B65FB0E70F5295D (screening_id), UNIQUE INDEX unique_seat_screening (screening_id, `row_number`, seat_number), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE screening (id INT AUTO_INCREMENT NOT NULL, movie_id INT NOT NULL, hall_id INT NOT NULL, start_time DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_B708297D8F93B6FC (movie_id), INDEX IDX_B708297D52AFCFD6 (hall_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495570F5295D FOREIGN KEY (screening_id) REFERENCES screening (id)');
        $this->addSql('ALTER TABLE reservation_seat ADD CONSTRAINT FK_2B65FB0EB83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id)');
        $this->addSql('ALTER TABLE reservation_seat ADD CONSTRAINT FK_2B65FB0E70F5295D FOREIGN KEY (screening_id) REFERENCES screening (id)');
        $this->addSql('ALTER TABLE screening ADD CONSTRAINT FK_B708297D8F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id)');
        $this->addSql('ALTER TABLE screening ADD CONSTRAINT FK_B708297D52AFCFD6 FOREIGN KEY (hall_id) REFERENCES hall (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495570F5295D');
        $this->addSql('ALTER TABLE reservation_seat DROP FOREIGN KEY FK_2B65FB0EB83297E7');
        $this->addSql('ALTER TABLE reservation_seat DROP FOREIGN KEY FK_2B65FB0E70F5295D');
        $this->addSql('ALTER TABLE screening DROP FOREIGN KEY FK_B708297D8F93B6FC');
        $this->addSql('ALTER TABLE screening DROP FOREIGN KEY FK_B708297D52AFCFD6');
        $this->addSql('DROP TABLE hall');
        $this->addSql('DROP TABLE movie');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE reservation_seat');
        $this->addSql('DROP TABLE screening');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
