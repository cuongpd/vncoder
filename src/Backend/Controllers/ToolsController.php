<?php

namespace VnCoder\Backend\Controllers;

class ToolsController extends BackendController
{
    public function Debugbar_Action_Submit()
    {
        if ($this->debugbar) {
            cookie(['_debugbar' => 'off']);
            $message = 'Chế độ Debug đã tắt';
        } else {
            cookie(['_debugbar' => 'on']);
            $message = 'Chế độ Debug đã được bật';
        }
        flash_message($message);
        return response()->json(['message' => $message]);
    }

    public function Shopee_Action()
    {
        $this->metaData->title = 'Tool Săn Shopee';
        $this->initDataTable();
        return $this->views('tools.shopee');
    }

    public function Shopee_Ajax_Action()
    {
        debugbar_off();
        $cacheKey = 'shopee_query_data_query';
        $data = cache($cacheKey);
        if (!$data) {
            $query = $this->getFlashSaleData();
            $data = array();
            foreach ($query as $item) {
                $info = array();
                $shopeeLink = 'https://shopee.vn/' . urlencode($item['name']). '-i.' .$item['shopid']. '.' .$item['itemid'];
                $info[] = "<img src='https://cf.shopee.vn/file/".$item['image']."_tn' style='max-height:50px'>";
                $info[] = "<a href='".$shopeeLink."' target='_blank'>".$item['name']. '</a>';
                $info[] = number_format($item['price']/100000);
                $info[] = number_format($item['price_before_discount']/100000);
                $info[] = number_format($item['price_before_discount']/100000 - $item['price']/100000);
                // $info[] = number_format(100 * ($item['price_before_discount'] - $item['price'])/$item['price_before_discount'] , 2)."%";
                $info[] = $item['discount'];
                $info[] = $item['stock'];
                $data[] = $info;
            }
            cache($cacheKey, $data, 360);
        }

        return response()->json(array('data' => $data));
    }

    protected function getShopeeImage($code)
    {
        return 'https://cf.shopee.vn/file/'.$code.'_tn';
    }

    protected function getFlashSaleData()
    {
        $ch = curl_init();
        $params = [
            'limit' => 500,
            'sort_soldout' => 'true',
            'need_personalize' => 'false',
            'with_brandsale_items' => 'true',
            'with_dp_items' => 'true'
        ];

        curl_setopt($ch, CURLOPT_URL, 'https://mall.shopee.vn/api/v2/flash_sale/flash_sale_get_items?' . http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

        $headers = array();
        $headers[] = 'Host: mall.shopee.vn';
        $headers[] = 'Cookie: SPC_AFTID=F458C6A8-C4E5-4D0F-A055-61911A9AF346; SPC_CLIENTID=BC34C35362A9494Cqdvcndwjmlmmeeux; shopee_app_version=25807; shopee_rn_version=1593597865; SPC_EC=-; SPC_R_T_ID=\"YEosv4g0Brvbbu8bWNbmKG/QP0WxQ+OmRltvLEBQZqSQO0R5NgQ6AUEODKoy1g+he7qoOESniOluZ8SUtNOngOaHM/V3mC75h0EeF9z2RoU=\"; SPC_R_T_IV=\"W6TZQM8MZQ5O9NTR3WRu0g==\"; SPC_SI=5y0n6dobngc3xlnnkdxve8ue3req2avo; SPC_T_ID=\"YEosv4g0Brvbbu8bWNbmKG/QP0WxQ+OmRltvLEBQZqSQO0R5NgQ6AUEODKoy1g+he7qoOESniOluZ8SUtNOngOaHM/V3mC75h0EeF9z2RoU=\"; SPC_T_IV=\"W6TZQM8MZQ5O9NTR3WRu0g==\"; SPC_F=BC34C35362A9494C950931F016C75B72; SPC_RNBV=4024000; language=vi; _ga=GA1.2.1398915145.1599611732; _gid=GA1.2.621054226.1599611732; csrftoken=nmIQf7w1gIQme0b6oNKBy6yU9ItKZSgX; SPC_U=-; REC_T_ID=89f89aba-da02-11ea-9a44-501d939e290e; SPC_IA=-1';
        $headers[] = 'X-Api-Source: rn';
        $headers[] = 'Accept: */*';
        $headers[] = 'Referer: https://mall.shopee.vn/bridge_cmd?cmd=reactPath%3Ftab%3Dbuy%26path%3Dshopee%2FHOME_PAGE';
        $headers[] = 'X-Shopee-Language: vi';
        $headers[] = 'If-None-Match-: 55b03-7119632936170c3bd9fe56afcf97dcfd';
        $headers[] = 'Accept-Language: vi-vn';
        $headers[] = 'User-Agent: iOS app iPhone Shopee appver=25807';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            info('Error:' . curl_error($ch));
            return false;
        }
        curl_close($ch);
        $data = json_decode($result, true);
        return $data['data']['items'] ?? false;
    }
}
