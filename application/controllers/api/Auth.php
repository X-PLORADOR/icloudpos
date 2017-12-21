<?php

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('login/login_api_model');
		$this->load->model('opciones/opciones_api_model');
        $this->load->model('api/api_model', 'apiModel');
		$this->load->library('user_agent');
    }

    public function index()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
		
		// Validar
		if (!empty($username) && !empty($password)) 
		{
			$data = array(
				'username' => $username,
				'password' => md5($password)
			);
			
			// Validar Usuario
			$auth = $this->login_api_model->verificar_usuario($data);
			
			if (count($auth) > 0) 
			{
				// Clear Password
				unset($auth['var_usuario_clave']);
				
				// Is Mobile
				if ($this->agent->is_mobile())
				{
					if ($auth['smovil'] == false)
					{
						echo json_encode(array('status' => 'failed'));
						exit();
					}
				}
				
				// Config
				$config = array();
				$configuraciones = $this->opciones_api_model->get_opciones();
				if ($configuraciones == TRUE) {
					foreach ($configuraciones as $configuracion) {
						$index          = $configuracion['config_key'];
						$config[$index] = $configuracion['config_value'];
					}
				}

                $config['tipos_documento'] = array('FACTURA', 'BOLETA DE VENTA');
				
				// Nuevo Api Key
				$apiKey = $this->apiModel->new_api_key($auth['nUsuCodigo'], $level = false, $ignore_limits = false, $is_private_key = false, $ip_addresses = '');
				
				// Json Array
				$json = array(
					'status'  => 'success', 
					'auth'    => $auth,
					'config'  => $config,
					'api_key' => $apiKey,
				);
				
				echo json_encode($json);
			} else {
				echo json_encode(array('status' => 'ne'));
			}
		} else {
			echo json_encode(array('status' => 'failed'));
		}
    }
}