<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240711163524 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'création des tables service, tag, offre ainsi que leurs relations';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE offre_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE service_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tag_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE offre (id INT NOT NULL, service_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, description TEXT NOT NULL, salaire NUMERIC(6, 2) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_AF86866FED5CA9E6 ON offre (service_id)');
        $this->addSql('CREATE TABLE offre_offre (offre_source INT NOT NULL, offre_target INT NOT NULL, PRIMARY KEY(offre_source, offre_target))');
        $this->addSql('CREATE INDEX IDX_F8AC61F438001F58 ON offre_offre (offre_source)');
        $this->addSql('CREATE INDEX IDX_F8AC61F421E54FD7 ON offre_offre (offre_target)');
        $this->addSql('CREATE TABLE service (id INT NOT NULL, nom VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE tag (id INT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866FED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE offre_offre ADD CONSTRAINT FK_F8AC61F438001F58 FOREIGN KEY (offre_source) REFERENCES offre (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE offre_offre ADD CONSTRAINT FK_F8AC61F421E54FD7 FOREIGN KEY (offre_target) REFERENCES offre (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE offre_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE service_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tag_id_seq CASCADE');
        $this->addSql('ALTER TABLE offre DROP CONSTRAINT FK_AF86866FED5CA9E6');
        $this->addSql('ALTER TABLE offre_offre DROP CONSTRAINT FK_F8AC61F438001F58');
        $this->addSql('ALTER TABLE offre_offre DROP CONSTRAINT FK_F8AC61F421E54FD7');
        $this->addSql('DROP TABLE offre');
        $this->addSql('DROP TABLE offre_offre');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
