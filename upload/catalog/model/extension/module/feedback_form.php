<?php
class ModelExtensionModuleFeedbackForm extends Model
{
  public function addFeedback($data)
  {
    $this->db->query("INSERT INTO " . DB_PREFIX . "feedback_form SET 
            name = '" . $this->db->escape($data['name']) . "',
            email = '" . $this->db->escape($data['email']) . "',
            phone = '" . $this->db->escape($data['phone']) . "',
            page = '" . $this->db->escape($data['page']) . "'
        ");
  }
}
