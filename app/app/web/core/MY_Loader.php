<?php
class MY_Loader extends CI_Loader {
	public function template($template_name, $var = array(), $return = false) {
		if($return) {
			$content = $this->view("template/header", $var, $return);
			$content .= $this->view($template_name, $var, $return);
			$content .= $this->view("template/footer", $var, $return);
			return $content;
		} else {
			$this->view("template/header", $var, $return);
			$this->view($template_name, $var, $return);
			$this->view("template/footer", $var, $return);
		}
	}
	
	public function template_mobile($template_name, $var = array(), $return = false) {
		if($return) {
			$content = $this->view("mobile/template/header", $var, $return);
			$content .= $this->view($template_name, $var, $return);
			$content .= $this->view("mobile/template/footer", $var, $return);
			return $content;
		} else {
			$this->view("mobile/template/header", $var, $return);
			$this->view($template_name, $var, $return);
			$this->view("mobile/template/footer", $var, $return);
		}
	}
	
	public function template_mobile_with_menu($template_name, $var = array(), $return = false) {
		if($return) {
			$content = $this->view("mobile/template/header", $var, $return);
			$content = $this->view("mobile/template/menu_header", $var, $return);
			$content .= $this->view($template_name, $var, $return);
			$content .= $this->view("mobile/template/footer", $var, $return);
			return $content;
		} else {
			$this->view("mobile/template/header", $var, $return);
			$this->view("mobile/template/menu_header", $var, $return);
			$this->view($template_name, $var, $return);
			$this->view("mobile/template/footer", $var, $return);
		}
	}
}