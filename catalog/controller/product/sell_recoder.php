<?php
class ControllerProductSellRecoder extends Controller{

    public function index()
    {
        $this->load->language('product/product');

        if (isset($this->request->get['product_id'])) {
            $product_id = (int)$this->request->get['product_id'];
        } else {
            $product_id = 0;
        }


        $this->load->model('catalog/product');

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        $data['resultsorders'] = array();

        $resultsorders_total = $this->model_catalog_product->getOrderProductIdTotal($this->request->get['product_id']);
        //var_dump($resultsorders_total);
        $resultsorders = $this->model_catalog_product->getOrderProductId($this->request->get['product_id'],($page - 1) * 20, 20);
        foreach ($resultsorders as $resultsorder) {
            $data['resultsorders'][] = array(
                'order_id' => $resultsorder['order_id'],
                'username' => $this->mask_name($resultsorder['firstname'], '*', $percent=50),
                'value' => $resultsorder['value'],
                'date_modified' => $resultsorder['date_modified'],
            );
        }
        $pagination = new Pagination();
        $pagination->total = $resultsorders_total;
        $pagination->page = $page;
        $pagination->limit = 20;
        $pagination->url = $this->url->link('product/sell_recoder', 'product_id=' . $this->request->get['product_id'] . '&page={page}', 'SSL');

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($resultsorders_total) ? (($page - 1) * 20) + 1 : 0, ((($page - 1) * 20) > ($resultsorders_total - 20)) ? $resultsorders_total : ((($page - 1) * 20) + 20), $resultsorders_total, ceil($resultsorders_total / 20));

//        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/sell_recoder.tpl')) {
//            return $this->load->view($this->config->get('config_template') . '/template/product/sell_recoder.tpl', $data);
//        }
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/sell_recoder.tpl')) {
            $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/product/sell_recoder.tpl', $data));
        }
    }
    public function mask_name($name, $mask_char, $percent=50) {
        $user = $name;
        $len = 3;
        $masked =strlen($user)<=$len ? $user : (substr($user,0,$len).chr(0)."***");
        return $masked;
    }


}