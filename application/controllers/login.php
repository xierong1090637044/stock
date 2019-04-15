<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct(){
        parent::__construct();
    }

	public function index(){
	    $data = str_enhtml($this->input->post(NULL,TRUE));
		if (is_array($data)&&count($data)>0) {
			!token(1) && die('token验证失败');
			strlen($data['username']) < 1 && die('用户名不能为空');
			strlen($data['userpwd']) < 1  && die('密码不能为空');
			$user = $this->mysql_model->get_rows('admin','(username="'.$data['username'].'") or (mobile="'.$data['username'].'") ');
			if (count($user)>0) {
			    $user['status']!=1 && die('账号被锁定');
				if ($user['userpwd'] == md5($data['userpwd'])) {
					$data['jxcsys']['uid']      = $user['uid'];
					$data['jxcsys']['name']     = $user['name'];
					$data['jxcsys']['roleid']   = $user['roleid'];
					$data['jxcsys']['username'] = $user['username'];
					$data['jxcsys']['login']    = 'jxc';
					if (isset($data['ispwd']) && $data['ispwd'] == 1) {
					   $this->input->set_cookie('username',$data['username'],3600000);
						$this->input->set_cookie('userpwd',$data['userpwd'],3600000);
					}

          if($user['roleid'] == 0)
          {
            $this->input->set_cookie('parent',$user['uid'],3600000);
          }else {
            $this->input->set_cookie('parent',$user['parent'],3600000);
          }
					$this->input->set_cookie('ispwd',$data['ispwd'],3600000);
          $this->input->set_cookie('uid',$user['uid'],3600000);
					$this->session->set_userdata($data);
					$this->common_model->logs('登陆成功 用户名：'.$data['username']);
					die('1');
			   }
			}
			die('账号或密码错误');
		} else {
		    $this->load->view('login',$data);
		}
	}

	public function out(){
	    $this->session->sess_destroy();
      redirect(site_url('login'));
	}

  //用户注册
  public function test(){
    $time=time();//获取系统时间
    preg_match('/\d{10}/',$time,$matches);
    $newTime= (date('Y-m-d H:i:s',$matches[0]));

    $data = str_enhtml($this->input->post(NULL,TRUE));
    if (is_array($data)&&count($data)>0) {
    strlen($data['username']) < 1 && die('用户名不能为空');
    strlen($data['userpwd']) < 1  && die('密码不能为空');
    strlen($data['mobile']) < 1  && die('手机不能为空');
    strlen($data['mobile']) < 11  && die('手机号不正确');
    strlen($data['mail']) < 1  && die('邮箱不能为空');
    $this->mysql_model->get_count('admin',array('username'=>$data['username']))>0 && str_alert(-1,'用户名已经存在');
    $this->mysql_model->get_count('admin',array('mobile'=>$data['mobile'])) >0 && str_alert(-1,'该手机号已被使用');
    $this->mysql_model->get_count('admin',array('mobile'=>$data['main'])) >0 && str_alert(-1,'该邮箱已被使用');
    $info = array(
       'username' => $data['username'],
       'userpwd'  => md5($data['userpwd']),
       'name'     => $data['username'],
       'mobile'   => $data['mobile'],
       'mail'   => $data['mail'],
       'rightids' => null,
       'roleid' => 0,
       'created' => $newTime,
    );
      $sql = $this->mysql_model->insert('admin',$info);
      if ($sql) {
        $this->input->set_cookie('ispwd',$data['userpwd'],3600000);
        $this->input->set_cookie('username',$user['username'],3600000);
        $list  = $this->mysql_model->get_results('admin',array('username'=>$data['username'],'userpwd'=>md5($data['userpwd'])));
        $sql = $this->mysql_model->update('admin',array('parent'=>$list[0]["uid"]),array('uid'=>$list[0]["uid"]));
        $this->common_model->logs('登陆成功 用户名：'.$data['username']);
				die('1');
			}
  } else {
    $this->load->view('test',$data);
  }
	}

	public function code(){
	    $this->load->library('lib_code');
      $this->lib_code->image();
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
