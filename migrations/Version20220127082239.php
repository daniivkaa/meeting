<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220127082239 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, meeting_id INT DEFAULT NULL, text LONGTEXT NOT NULL, INDEX IDX_9474526C67433D9C (meeting_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE meeting (id INT AUTO_INCREMENT NOT NULL, subject_id INT DEFAULT NULL, date_meeting DATE NOT NULL, time_meeting TIME NOT NULL, arrival_time TIME DEFAULT NULL, start_time TIME DEFAULT NULL, is_successful TINYINT(1) DEFAULT NULL, INDEX IDX_F515E13923EDC87 (subject_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, INDEX IDX_D044D5D4A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subject (id INT AUTO_INCREMENT NOT NULL, session_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, teacherÐer_first_name VARCHAR(255) NOT NULL, teacher_last_name VARCHAR(255) NOT NULL, teacher_patronymic VARCHAR(255) NOT NULL, INDEX IDX_FBCE3E7A613FECDF (session_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C67433D9C FOREIGN KEY (meeting_id) REFERENCES meeting (id)');
        $this->addSql('ALTER TABLE meeting ADD CONSTRAINT FK_F515E13923EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE subject ADD CONSTRAINT FK_FBCE3E7A613FECDF FOREIGN KEY (session_id) REFERENCES session (id)');
        $this->addSql('ALTER TABLE user ADD first_name VARCHAR(255) NOT NULL, ADD last_name VARCHAR(255) DEFAULT NULL, ADD patronymic VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C67433D9C');
        $this->addSql('ALTER TABLE subject DROP FOREIGN KEY FK_FBCE3E7A613FECDF');
        $this->addSql('ALTER TABLE meeting DROP FOREIGN KEY FK_F515E13923EDC87');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE meeting');
        $this->addSql('DROP TABLE session');
        $this->addSql('DROP TABLE subject');
        $this->addSql('ALTER TABLE user DROP first_name, DROP last_name, DROP patronymic');
    }
}
