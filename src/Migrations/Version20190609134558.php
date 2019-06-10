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

final class Version20190609134558 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE order_taxi ADD from_address_id INT NOT NULL, ADD to_address_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE order_taxi ADD CONSTRAINT FK_127559D5DE136972 FOREIGN KEY (from_address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE order_taxi ADD CONSTRAINT FK_127559D5D2844D08 FOREIGN KEY (to_address_id) REFERENCES address (id)');
        $this->addSql('CREATE INDEX IDX_127559D5DE136972 ON order_taxi (from_address_id)');
        $this->addSql('CREATE INDEX IDX_127559D5D2844D08 ON order_taxi (to_address_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE order_taxi DROP FOREIGN KEY FK_127559D5DE136972');
        $this->addSql('ALTER TABLE order_taxi DROP FOREIGN KEY FK_127559D5D2844D08');
        $this->addSql('DROP INDEX IDX_127559D5DE136972 ON order_taxi');
        $this->addSql('DROP INDEX IDX_127559D5D2844D08 ON order_taxi');
        $this->addSql('ALTER TABLE order_taxi DROP from_address_id, DROP to_address_id');
    }
}
