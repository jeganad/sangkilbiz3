<?php

namespace biz\master\hooks;

use biz\app\Hooks;
use biz\master\components\Helper;
use biz\master\models\PriceCategory;
use biz\master\models\Price;
use yii\base\UserException;

/**
 * Description of Price
 *
 * @author MDMunir
 */
class PriceHook extends \yii\base\Behavior
{

    public function events()
    {
        return [
            Hooks::E_PPREC_22 => 'purchaseReceiveBody'
        ];
    }

    private function executePriceFormula($_formula_, $price)
    {
        if (empty($_formula_)) {
            return $price;
        }
        $_formula_ = preg_replace('/price/i', '$price', $_formula_);

        return empty($_formula_) ? $price : eval("return $_formula_;");
    }

    protected function updatePrice($params)
    {
        $categories = PriceCategory::find()->all();
        foreach ($categories as $category) {
            $price = Price::findOne([
                    'id_product' => $params['id_product'],
                    'id_price_category' => $category->id_price_category
            ]);

            if (!$price) {
                $price = new Price();
                $price->setAttributes([
                    'id_product' => $params['id_product'],
                    'id_price_category' => $category->id_price_category,
                    'id_uom' => $params['id_uom'],
                    'price' => 0
                ]);
            }

            if ($price->canSetProperty('logParams')) {
                $logParams = [];
                foreach (['app','id_ref'] as $key) {
                    if (isset($params[$key]) || array_key_exists($key, $params)) {
                        $logParams[$key] = $params[$key];
                    }
                }
                $price->logParams = $logParams;
            }
            $price->price = $this->executePriceFormula($category->formula, $params['price']);
            if (!$price->save()) {
                throw new UserException(implode(",\n", $price->firstErrors));
            }
        }

        return true;
    }

    /**
     *
     * @param \biz\app\base\Event $event
     */
    public function purchaseReceiveBody($event)
    {
        /* @var $detail \biz\master\models\PurchaseDtl */
        $detail = $event->params[1];
        $smallest_uom = Helper::getSmallestProductUom($detail->id_product);

        $this->updatePrice([
            'id_product' => $detail->id_product,
            'id_uom' => $smallest_uom,
            'price' => $detail->sales_price,
            'app' => 'purchase',
            'id_ref' => $detail->id_purchase_dtl,
        ]);
    }
}
