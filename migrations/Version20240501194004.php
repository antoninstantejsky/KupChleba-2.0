<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240501194004 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE pma__bookmark');
        $this->addSql('DROP TABLE pma__history');
        $this->addSql('DROP TABLE pma__favorite');
        $this->addSql('DROP TABLE pma__navigationhiding');
        $this->addSql('DROP TABLE pma__pdf_pages');
        $this->addSql('DROP TABLE pma__export_templates');
        $this->addSql('DROP TABLE pma__recent');
        $this->addSql('DROP TABLE pma__designer_settings');
        $this->addSql('DROP TABLE pma__relation');
        $this->addSql('DROP TABLE pma__savedsearches');
        $this->addSql('DROP TABLE pma__table_coords');
        $this->addSql('DROP TABLE pma__table_info');
        $this->addSql('DROP TABLE pma__column_info');
        $this->addSql('DROP TABLE pma__tracking');
        $this->addSql('DROP TABLE pma__users');
        $this->addSql('DROP TABLE pma__userconfig');
        $this->addSql('DROP TABLE pma__table_uiprefs');
        $this->addSql('DROP TABLE pma__usergroups');
        $this->addSql('DROP TABLE pma__central_columns');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pma__bookmark (id INT UNSIGNED AUTO_INCREMENT NOT NULL, dbase VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT \'\' NOT NULL COLLATE `utf8mb3_bin`, user VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT \'\' NOT NULL COLLATE `utf8mb3_bin`, label VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT \'\' NOT NULL COLLATE `utf8mb3_general_ci`, query TEXT CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_bin`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_bin` ENGINE = InnoDB COMMENT = \'Bookmarks\' ');
        $this->addSql('CREATE TABLE pma__history (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, username VARCHAR(64) CHARACTER SET utf8mb3 DEFAULT \'\' NOT NULL COLLATE `utf8mb3_bin`, db VARCHAR(64) CHARACTER SET utf8mb3 DEFAULT \'\' NOT NULL COLLATE `utf8mb3_bin`, `table` VARCHAR(64) CHARACTER SET utf8mb3 DEFAULT \'\' NOT NULL COLLATE `utf8mb3_bin`, timevalue DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, sqlquery TEXT CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_bin`, INDEX username (username, db, `table`, timevalue), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_bin` ENGINE = InnoDB COMMENT = \'SQL history for phpMyAdmin\' ');
        $this->addSql('CREATE TABLE pma__favorite (username VARCHAR(64) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_bin`, tables TEXT CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_bin`, PRIMARY KEY(username)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_bin` ENGINE = InnoDB COMMENT = \'Favorite tables\' ');
        $this->addSql('CREATE TABLE pma__navigationhiding (username VARCHAR(64) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_bin`, item_name VARCHAR(64) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_bin`, item_type VARCHAR(64) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_bin`, db_name VARCHAR(64) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_bin`, table_name VARCHAR(64) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_bin`, PRIMARY KEY(username, item_name, item_type, db_name, table_name)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_bin` ENGINE = InnoDB COMMENT = \'Hidden items of navigation tree\' ');
        $this->addSql('CREATE TABLE pma__pdf_pages (page_nr INT UNSIGNED AUTO_INCREMENT NOT NULL, db_name VARCHAR(64) CHARACTER SET utf8mb3 DEFAULT \'\' NOT NULL COLLATE `utf8mb3_bin`, page_descr VARCHAR(50) CHARACTER SET utf8mb3 DEFAULT \'\' NOT NULL COLLATE `utf8mb3_general_ci`, INDEX db_name (db_name), PRIMARY KEY(page_nr)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_bin` ENGINE = InnoDB COMMENT = \'PDF relation pages for phpMyAdmin\' ');
        $this->addSql('CREATE TABLE pma__export_templates (id INT UNSIGNED AUTO_INCREMENT NOT NULL, username VARCHAR(64) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_bin`, export_type VARCHAR(10) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_bin`, template_name VARCHAR(64) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_bin`, template_data TEXT CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_bin`, UNIQUE INDEX u_user_type_template (username, export_type, template_name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_bin` ENGINE = InnoDB COMMENT = \'Saved export templates\' ');
        $this->addSql('CREATE TABLE pma__recent (username VARCHAR(64) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_bin`, tables TEXT CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_bin`, PRIMARY KEY(username)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_bin` ENGINE = InnoDB COMMENT = \'Recently accessed tables\' ');
        $this->addSql('CREATE TABLE pma__designer_settings (username VARCHAR(64) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_bin`, settings_data TEXT CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_bin`, PRIMARY KEY(username)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_bin` ENGINE = InnoDB COMMENT = \'Settings related to Designer\' ');
        $this->addSql('CREATE TABLE pma__relation (master_db VARCHAR(64) CHARACTER SET utf8mb3 DEFAULT \'\' NOT NULL COLLATE `utf8mb3_bin`, master_table VARCHAR(64) CHARACTER SET utf8mb3 DEFAULT \'\' NOT NULL COLLATE `utf8mb3_bin`, master_field VARCHAR(64) CHARACTER SET utf8mb3 DEFAULT \'\' NOT NULL COLLATE `utf8mb3_bin`, foreign_db VARCHAR(64) CHARACTER SET utf8mb3 DEFAULT \'\' NOT NULL COLLATE `utf8mb3_bin`, foreign_table VARCHAR(64) CHARACTER SET utf8mb3 DEFAULT \'\' NOT NULL COLLATE `utf8mb3_bin`, foreign_field VARCHAR(64) CHARACTER SET utf8mb3 DEFAULT \'\' NOT NULL COLLATE `utf8mb3_bin`, INDEX foreign_field (foreign_db, foreign_table), PRIMARY KEY(master_db, master_table, master_field)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_bin` ENGINE = InnoDB COMMENT = \'Relation table\' ');
        $this->addSql('CREATE TABLE pma__savedsearches (id INT UNSIGNED AUTO_INCREMENT NOT NULL, username VARCHAR(64) CHARACTER SET utf8mb3 DEFAULT \'\' NOT NULL COLLATE `utf8mb3_bin`, db_name VARCHAR(64) CHARACTER SET utf8mb3 DEFAULT \'\' NOT NULL COLLATE `utf8mb3_bin`, search_name VARCHAR(64) CHARACTER SET utf8mb3 DEFAULT \'\' NOT NULL COLLATE `utf8mb3_bin`, search_data TEXT CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_bin`, UNIQUE INDEX u_savedsearches_username_dbname (username, db_name, search_name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_bin` ENGINE = InnoDB COMMENT = \'Saved searches\' ');
        $this->addSql('CREATE TABLE pma__table_coords (db_name VARCHAR(64) CHARACTER SET utf8mb3 DEFAULT \'\' NOT NULL COLLATE `utf8mb3_bin`, table_name VARCHAR(64) CHARACTER SET utf8mb3 DEFAULT \'\' NOT NULL COLLATE `utf8mb3_bin`, pdf_page_number INT DEFAULT 0 NOT NULL, x DOUBLE PRECISION UNSIGNED DEFAULT \'0\' NOT NULL, y DOUBLE PRECISION UNSIGNED DEFAULT \'0\' NOT NULL, PRIMARY KEY(db_name, table_name, pdf_page_number)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_bin` ENGINE = InnoDB COMMENT = \'Table coordinates for phpMyAdmin PDF output\' ');
        $this->addSql('CREATE TABLE pma__table_info (db_name VARCHAR(64) CHARACTER SET utf8mb3 DEFAULT \'\' NOT NULL COLLATE `utf8mb3_bin`, table_name VARCHAR(64) CHARACTER SET utf8mb3 DEFAULT \'\' NOT NULL COLLATE `utf8mb3_bin`, display_field VARCHAR(64) CHARACTER SET utf8mb3 DEFAULT \'\' NOT NULL COLLATE `utf8mb3_bin`, PRIMARY KEY(db_name, table_name)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_bin` ENGINE = InnoDB COMMENT = \'Table information for phpMyAdmin\' ');
        $this->addSql('CREATE TABLE pma__column_info (id INT UNSIGNED AUTO_INCREMENT NOT NULL, db_name VARCHAR(64) CHARACTER SET utf8mb3 DEFAULT \'\' NOT NULL COLLATE `utf8mb3_bin`, table_name VARCHAR(64) CHARACTER SET utf8mb3 DEFAULT \'\' NOT NULL COLLATE `utf8mb3_bin`, column_name VARCHAR(64) CHARACTER SET utf8mb3 DEFAULT \'\' NOT NULL COLLATE `utf8mb3_bin`, comment VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT \'\' NOT NULL COLLATE `utf8mb3_general_ci`, mimetype VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT \'\' NOT NULL COLLATE `utf8mb3_general_ci`, transformation VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT \'\' NOT NULL COLLATE `utf8mb3_bin`, transformation_options VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT \'\' NOT NULL COLLATE `utf8mb3_bin`, input_transformation VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT \'\' NOT NULL COLLATE `utf8mb3_bin`, input_transformation_options VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT \'\' NOT NULL COLLATE `utf8mb3_bin`, UNIQUE INDEX db_name (db_name, table_name, column_name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_bin` ENGINE = InnoDB COMMENT = \'Column information for phpMyAdmin\' ');
        $this->addSql('CREATE TABLE pma__tracking (db_name VARCHAR(64) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_bin`, table_name VARCHAR(64) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_bin`, version INT UNSIGNED NOT NULL, date_created DATETIME NOT NULL, date_updated DATETIME NOT NULL, schema_snapshot TEXT CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_bin`, schema_sql TEXT CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_bin`, data_sql LONGTEXT CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_bin`, tracking LONGTEXT CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_bin` COMMENT \'(DC2Type:simple_array)\', tracking_active INT UNSIGNED DEFAULT 1 NOT NULL, PRIMARY KEY(db_name, table_name, version)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_bin` ENGINE = InnoDB COMMENT = \'Database changes tracking for phpMyAdmin\' ');
        $this->addSql('CREATE TABLE pma__users (username VARCHAR(64) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_bin`, usergroup VARCHAR(64) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_bin`, PRIMARY KEY(username, usergroup)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_bin` ENGINE = InnoDB COMMENT = \'Users and their assignments to user groups\' ');
        $this->addSql('CREATE TABLE pma__userconfig (username VARCHAR(64) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_bin`, timevalue DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, config_data TEXT CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_bin`, PRIMARY KEY(username)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_bin` ENGINE = InnoDB COMMENT = \'User preferences storage for phpMyAdmin\' ');
        $this->addSql('CREATE TABLE pma__table_uiprefs (username VARCHAR(64) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_bin`, db_name VARCHAR(64) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_bin`, table_name VARCHAR(64) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_bin`, prefs TEXT CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_bin`, last_update DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(username, db_name, table_name)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_bin` ENGINE = InnoDB COMMENT = \'Tables\'\' UI preferences\' ');
        $this->addSql('CREATE TABLE pma__usergroups (usergroup VARCHAR(64) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_bin`, tab VARCHAR(64) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_bin`, allowed VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT \'N\' NOT NULL COLLATE `utf8mb3_bin`, PRIMARY KEY(usergroup, tab, allowed)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_bin` ENGINE = InnoDB COMMENT = \'User groups with configured menu items\' ');
        $this->addSql('CREATE TABLE pma__central_columns (db_name VARCHAR(64) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_bin`, col_name VARCHAR(64) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_bin`, col_type VARCHAR(64) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_bin`, col_length TEXT CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_bin`, col_collation VARCHAR(64) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_bin`, col_isNull TINYINT(1) NOT NULL, col_extra VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT \'\' COLLATE `utf8mb3_bin`, col_default TEXT CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_bin`, PRIMARY KEY(db_name, col_name)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_bin` ENGINE = InnoDB COMMENT = \'Central list of columns\' ');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
