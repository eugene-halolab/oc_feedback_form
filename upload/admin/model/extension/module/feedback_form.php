<?php
class ModelExtensionModuleFeedbackForm extends Model
{
  public function install()
  {
    $this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "feedback_form (
          id INT AUTO_INCREMENT,
          name VARCHAR(255) NOT NULL,
          email VARCHAR(255) NOT NULL,
          phone VARCHAR(20) NOT NULL,
          page VARCHAR(255) NOT NULL,
          created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
          PRIMARY KEY (id)
      ) ENGINE=MyISAM DEFAULT COLLATE=utf8_general_ci;");
  }
}
