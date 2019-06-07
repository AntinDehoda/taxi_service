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
final class Version20190605213554 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE district (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE street ADD district_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE street ADD CONSTRAINT FK_F0EED3D8B08FA272 FOREIGN KEY (district_id) REFERENCES district (id)');
        $this->addSql('CREATE INDEX IDX_F0EED3D8B08FA272 ON street (district_id)');
        $this->addSql('ALTER TABLE client CHANGE current_order_id current_order_id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE street DROP FOREIGN KEY FK_F0EED3D8B08FA272');
        $this->addSql('DROP TABLE district');
        $this->addSql('ALTER TABLE client CHANGE current_order_id current_order_id INT DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_F0EED3D8B08FA272 ON street');
        $this->addSql('ALTER TABLE street DROP district_id');
    }
}
