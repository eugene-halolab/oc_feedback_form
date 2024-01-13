<?php
class ControllerExtensionModuleFeedbackForm extends Controller
{
    public function index() {
        $this->load->language('extension/module/feedback_form');
        $data['feedback_form'] = $this->url->link('extension/module/feedback_form/create', '', true);
        if (isset($this->request->get['route']) && isset($this->request->get['information_id'])) {
            $data['current_page'] = $this->url->link($this->request->get['route'], 'information_id=' . $this->request->get['information_id'], true);
        } else {
            $data['current_page'] = $this->url->link('common/home', '', true);
        }        
        return $this->load->view('extension/module/feedback_form', $data);
    }

    public function create() {
        $this->load->language('extension/module/feedback_form');
        $this->load->model('extension/module/feedback_form');

        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            $data = array(
                'name'     => $this->request->post['name'],
                'email'    => $this->request->post['email'],
                'phone'    => $this->request->post['phone'],
                'page'     => $this->request->post['page'],
            );

            $this->model_extension_module_feedback_form->addFeedback($data);

            $this->session->data['success'] = $this->language->get('text_success');
        }

        $this->response->redirect($this->request->post['page']);
    }
}
