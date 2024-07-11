<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240711164242 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE offre_tag (offre_id INT NOT NULL, tag_id INT NOT NULL, PRIMARY KEY(offre_id, tag_id))');
        $this->addSql('CREATE INDEX IDX_E3AFAFAA4CC8505A ON offre_tag (offre_id)');
        $this->addSql('CREATE INDEX IDX_E3AFAFAABAD26311 ON offre_tag (tag_id)');
        $this->addSql('ALTER TABLE offre_tag ADD CONSTRAINT FK_E3AFAFAA4CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE offre_tag ADD CONSTRAINT FK_E3AFAFAABAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE offre_offre DROP CONSTRAINT fk_f8ac61f438001f58');
        $this->addSql('ALTER TABLE offre_offre DROP CONSTRAINT fk_f8ac61f421e54fd7');
        $this->addSql('DROP TABLE offre_offre');
        $this->addSql('ALTER TABLE offre DROP CONSTRAINT fk_af86866fed5ca9e6');
        $this->addSql('DROP INDEX idx_af86866fed5ca9e6');
        $this->addSql('ALTER TABLE offre DROP service_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE offre_offre (offre_source INT NOT NULL, offre_target INT NOT NULL, PRIMARY KEY(offre_source, offre_target))');
        $this->addSql('CREATE INDEX idx_f8ac61f421e54fd7 ON offre_offre (offre_target)');
        $this->addSql('CREATE INDEX idx_f8ac61f438001f58 ON offre_offre (offre_source)');
        $this->addSql('ALTER TABLE offre_offre ADD CONSTRAINT fk_f8ac61f438001f58 FOREIGN KEY (offre_source) REFERENCES offre (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE offre_offre ADD CONSTRAINT fk_f8ac61f421e54fd7 FOREIGN KEY (offre_target) REFERENCES offre (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE offre_tag DROP CONSTRAINT FK_E3AFAFAA4CC8505A');
        $this->addSql('ALTER TABLE offre_tag DROP CONSTRAINT FK_E3AFAFAABAD26311');
        $this->addSql('DROP TABLE offre_tag');
        $this->addSql('ALTER TABLE offre ADD service_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT fk_af86866fed5ca9e6 FOREIGN KEY (service_id) REFERENCES service (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_af86866fed5ca9e6 ON offre (service_id)');
    }
}
