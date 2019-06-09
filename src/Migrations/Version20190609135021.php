<?php

declare(strict_types=1);

/*
 *
 * (c) Anton Dehoda <dehoda@ukr.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190609135021 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE order_taxi ADD taxi_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE order_taxi ADD CONSTRAINT FK_127559D5506FF81C FOREIGN KEY (taxi_id) REFERENCES taxi (id)');
        $this->addSql('CREATE INDEX IDX_127559D5506FF81C ON order_taxi (taxi_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE order_taxi DROP FOREIGN KEY FK_127559D5506FF81C');
        $this->addSql('DROP INDEX IDX_127559D5506FF81C ON order_taxi');
        $this->addSql('ALTER TABLE order_taxi DROP taxi_id');
    }
}
