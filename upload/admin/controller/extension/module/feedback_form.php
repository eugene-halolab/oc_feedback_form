<?php
class ControllerExtensionModuleFeedbackForm extends Controller
{
    private $error = array();

    public function install()
    {
		$this->load->model('extension/module/feedback_form');
		$this->model_extension_module_feedback_form->install();
    }

    public function index()
    {
        $this->load->language('extension/module/feedback_form');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('module_feedback_form', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
        }

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/module/feedback_form', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['action'] = $this->url->link('extension/module/feedback_form', 'user_token=' . $this->session->data['user_token'], true);

        $data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

        if (isset($this->request->post['module_feedback_form_status'])) {
            $data['module_feedback_form_status'] = $this->request->post['module_feedback_form_status'];
        } else {
            $data['module_feedback_form_status'] = $this->config->get('module_feedback_form_status');
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/feedback_form', $data));
    }

    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'extension/module/feedback_form')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }


    public function process() {
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

        $this->response->redirect($this->url->link('common/home'));
    }
}
