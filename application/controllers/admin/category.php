<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Category extends CI_Controller
{

	//this method will show category list page
	public function index()
	{
		$this->load->model('Category_model');
		$queryString = $this->input->get('q');
		$param['queryString'] = $queryString;
		$categories = $this->Category_model->getCategories($param);
		$data['categories'] = $categories;
		$data['queryString'] = $queryString;
		$this->load->view('admin/category/list', $data);
	}

	//this method will show create category  page
	public function create()
	{

		$this->load->helper('common_helper');
		$config['upload_path']          = './public/uploads/category';
		$config['allowed_types']        = 'gif|jpg|png';
		$config['encrypt_name']        = true;

		$this->load->library('upload', $config);
		$this->load->model('Category_model');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<p class="invalid-feedback">', '</p>');
		$this->form_validation->set_rules('name', 'Name', 'trim|required');

		if ($this->form_validation->run() == TRUE) {

			if (!empty($_FILES['image']['name'])) {

				//now user has selected a file so we will proceed
				if ($this->upload->do_upload('image')) {
					//file uploaded successfully

					$data = $this->upload->data();
					//resizing part

					resizeImage($config['upload_path'] . $data['file_name'], $config['upload_path'] . 'thumb/' . $data['file_name'], 300, 270);

					$formArray['image'] = $data['file_name'];
					$formArray['name'] = $this->input->post('name');
					$formArray['status'] = $this->input->post('status');
					$formArray['created_at'] = date('Y-m-d H:i:s');
					$this->Category_model->create($formArray);
					$this->session->set_flashdata('success', 'Category Added Successfully');

					redirect(base_url() . 'admin/category/index');
				} else {
					//we got error

					$error =  $this->upload->display_errors('<p class="invalid-feedback">', '</p>');
					$data['errorImageUpload'] = $error;
					$this->load->view('admin/category/create', $data);
				}
			} else {
				//we will create category without image
				$formArray['name'] = $this->input->post('name');
				$formArray['status'] = $this->input->post('status');
				$formArray['created_at'] = date('Y-m-d H:i:s');
				$this->Category_model->create($formArray);
				$this->session->set_flashdata('success', 'Category Added Successfully');
				redirect(base_url() . 'admin/category/index');
			}
		} else {
			//will show errors
		}

		$this->load->view('admin/category/create');
	}

	//this method will show edit category  page
	public function edit($id)
	{
		$this->load->model('Category_model');
		$category = $this->Category_model->getCategory($id);

		if (empty($category)) {
			$this->session->set_flashdata('error', 'Category not found');
			redirect(base_url() . 'admin/category/index');
		}

		$this->load->helper('common_helper');
		$config['upload_path']          = './public/uploads/category';
		$config['allowed_types']        = 'gif|jpg|png';
		$config['encrypt_name']        = true;

		$this->load->library('upload', $config);

		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<p class="invalid-feedback">', '</p>');
		$this->form_validation->set_rules('name', 'Name', 'trim|required');

		if ($this->form_validation->run() == TRUE) {


			if (!empty($_FILES['image']['name'])) {

				//now user has selected a file so we will proceed
				if ($this->upload->do_upload('image')) {
					//file uploaded successfully

					$data = $this->upload->data();
					//resizing part

					resizeImage($config['upload_path'] . $data['file_name'], $config['upload_path'] . 'thumb/' . $data['file_name'], 300, 270);

					$formArray['image'] = $data['file_name'];
					$formArray['name'] = $this->input->post('name');
					$formArray['status'] = $this->input->post('status');
					$formArray['update_at'] = date('Y-m-d H:i:s');

					$this->Category_model->update($id, $formArray);

					if (file_exists('./public/upload/category/' . $category['image'])) {
						unlink('./public/upload/category/' . $category['image']);
					}

					$this->session->set_flashdata('success', 'Category Updated Successfully');
					redirect(base_url() . 'admin/category/index');
				} else {
					//we got error

					$error =  $this->upload->display_errors('<p class="invalid-feedback">', '</p>');
					$data['errorImageUpload'] = $error;
					$data['category'] = $category;
					$this->load->view('admin/category/edit', $data);
				}
			} else {
				//we will update category without image
				$formArray['name'] = $this->input->post('name');
				$formArray['status'] = $this->input->post('status');
				$formArray['update_at'] = date('Y-m-d H:i:s');

				$this->Category_model->update($id, $formArray);

				$this->session->set_flashdata('success', 'Category Updated Successfully');
				redirect(base_url() . 'admin/category/index');
			}
		} else {
			$data['category'] = $category;
			$this->load->view('admin/category/edit', $data);
		}
	}

	//this method will show delete a category
	public function delete($id)
	{

		$this->load->model('Category_model');
		$category = $this->Category_model->getCategory($id);

		if (empty($category)) {
			$this->session->set_flashdata('error', 'Category not found');
			redirect(base_url() . 'admin/category/index');
		}

		if (file_exists('./public/upload/category/' . $category['image'])) {
			unlink('./public/upload/category/' . $category['image']);
		}

		$this->Category_model->delete($id);
		$this->session->set_flashdata('success', 'Category Deleted Successfully');
		redirect(base_url() . 'admin/category/index');
	}
}
