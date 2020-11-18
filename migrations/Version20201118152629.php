<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201118152629 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blog ADD local VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE cv ADD local VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE education ADD local VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE politic ADD local VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE project ADD local VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE service ADD local VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE tag ADD slug VARCHAR(255) NOT NULL, ADD local VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blog DROP local');
        $this->addSql('ALTER TABLE cv DROP local');
        $this->addSql('ALTER TABLE education DROP local');
        $this->addSql('ALTER TABLE politic DROP local');
        $this->addSql('ALTER TABLE project DROP local');
        $this->addSql('ALTER TABLE service DROP local');
        $this->addSql('ALTER TABLE tag DROP slug, DROP local');
    }
}
