<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230829095203 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE projects_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tasks_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE projects (id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, status VARCHAR(255) NOT NULL, deadline TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN projects.deadline IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN projects.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN projects.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE projects_user (projects_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(projects_id, user_id))');
        $this->addSql('CREATE INDEX IDX_B38D6A811EDE0F55 ON projects_user (projects_id)');
        $this->addSql('CREATE INDEX IDX_B38D6A81A76ED395 ON projects_user (user_id)');
        $this->addSql('CREATE TABLE tasks (id INT NOT NULL, project_id INT DEFAULT NULL, owner_id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, status VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_50586597166D1F9C ON tasks (project_id)');
        $this->addSql('CREATE INDEX IDX_505865977E3C61F9 ON tasks (owner_id)');
        $this->addSql('COMMENT ON COLUMN tasks.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN tasks.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('COMMENT ON COLUMN "user".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "user".updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE projects_user ADD CONSTRAINT FK_B38D6A811EDE0F55 FOREIGN KEY (projects_id) REFERENCES projects (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE projects_user ADD CONSTRAINT FK_B38D6A81A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tasks ADD CONSTRAINT FK_50586597166D1F9C FOREIGN KEY (project_id) REFERENCES projects (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tasks ADD CONSTRAINT FK_505865977E3C61F9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE projects_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tasks_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('ALTER TABLE projects_user DROP CONSTRAINT FK_B38D6A811EDE0F55');
        $this->addSql('ALTER TABLE projects_user DROP CONSTRAINT FK_B38D6A81A76ED395');
        $this->addSql('ALTER TABLE tasks DROP CONSTRAINT FK_50586597166D1F9C');
        $this->addSql('ALTER TABLE tasks DROP CONSTRAINT FK_505865977E3C61F9');
        $this->addSql('DROP TABLE projects');
        $this->addSql('DROP TABLE projects_user');
        $this->addSql('DROP TABLE tasks');
        $this->addSql('DROP TABLE "user"');
    }
}
