<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require(APPPATH.'/libraries/REST_Controller.php');
/**     
 * @OA\Info(title="Off POS API Documentation", version="1.1", description="Off POS API documentation description")
 */
class Configs extends REST_Controller
{   
    public function __construct() {
        parent::__construct(); 
    } 
    /**
 * @OA\get(
 *     path="/api/v1/ApiItemController/itemList",
 *     summary="Get Item List",
 *     tags={"Item"},
 *    @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function itemList_get(){}

/**
 * @OA\Post(
 *     path="/api/v1/ApiItemController/addItem",
 *     summary="Add Item",
 *     tags={"Item"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 example={
 *                     "api_auth_key": "3f77867f-a014-48f8-9366-83440279a80c",
 *                     "name": "",
 *                     "alternative_name": "wardrobe",
 *                     "type": "General_Product",
 *                     "category_name": "",
 *                     "brand_name": "RFL",
 *                     "supplier_name": "Mr.RFL",
 *                     "alert_quantity": "5",
 *                     "unit_type": "Single Unit",
 *                     "purchase_unit_name": "PCS",
 *                     "sale_unit_name": "PCS",
 *                     "conversion_rate": "1",
 *                     "purchase_price": "33",
 *                     "whole_sale_price": "40",
 *                     "sale_price": "55",
 *                     "description": "Item description",
 *                     "warranty": "1",
 *                     "warranty_type": "Year",
 *                     "guarantee": "1",
 *                     "guarantee_type": "Month",
 *                     "photo": "test.png",
 *                     "loyalty_point": "0",
 *                     "del_status": "Live",
 *                     "opening_stock": "[{'iem_description':'','stock_quantity':'20','outlet_name':'Mirput'},{'iem_description':'','stock_quantity':'20','outlet_name':'Uttara'}]",
 *                     "tax_information": "[{'tax_field_name':'CGST','tax_field_percentage':'20'},{'tax_field_name':'SGST','tax_field_percentage':'20'},{'tax_field_name':'IGST','tax_field_percentage':'20'},{'tax_field_name':'Vat','tax_field_percentage':'20'}]"
 *                 }
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function addItem_post() {}



 /**
 * @OA\post(
 *     path="/api/v1/ApiItemController/editItem",
 *     summary="Edit Item",
 *     tags={"Item"},
 *      @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 example={
 *                     "id": "1"
 *                 }
 *             )
 *         )
 *     ),
 *    @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function editItem_post(){}

/**
 * @OA\Post(
 *     path="/api/v1/ApiItemController/updateItem",
 *     summary="Update Item",
 *     tags={"Item"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 example={
 *                     "update_id": "1",
 *                     "api_auth_key": "3f77867f-a014-48f8-9366-83440279a80c",
 *                     "name": "",
 *                     "alternative_name": "wardrobe",
 *                     "type": "General_Product",
 *                     "category_name": "",
 *                     "brand_name": "RFL",
 *                     "supplier_name": "Mr.RFL",
 *                     "alert_quantity": "5",
 *                     "unit_type": "Single Unit",
 *                     "purchase_unit_name": "PCS",
 *                     "sale_unit_name": "PCS",
 *                     "conversion_rate": "1",
 *                     "purchase_price": "33",
 *                     "whole_sale_price": "40",
 *                     "sale_price": "55",
 *                     "description": "Item description",
 *                     "warranty": "1",
 *                     "warranty_type": "Year",
 *                     "guarantee": "1",
 *                     "guarantee_type": "Month",
 *                     "photo": "test.png",
 *                     "loyalty_point": "0",
 *                     "del_status": "Live",
 *                     "opening_stock": "[{'iem_description':'','stock_quantity':'20','outlet_name':'Mirput'},{'iem_description':'','stock_quantity':'20','outlet_name':'Uttara'}]",
 *                     "tax_information": "[{'tax_field_name':'CGST','tax_field_percentage':'20'},{'tax_field_name':'SGST','tax_field_percentage':'20'},{'tax_field_name':'IGST','tax_field_percentage':'20'},{'tax_field_name':'Vat','tax_field_percentage':'20'}]"
 *                 }

 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function updateItem_post() {}



/**
 * @OA\Post(
 *     path="/api/v1/ApiItemController/deleteItem",
 *     summary="Delete Item",
 *     tags={"Item"},
 *      @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 example={
 *                     "id": "1"
 *                 }
 *             )
 *         )
 *     ),
 *    @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function deleteItem_post(){}







/**
 * @OA\get(
 *     path="/api/v1/ApiSaleController/saleList",
 *     summary="Get Sale List",
 *     tags={"Sale"},
 *    @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function saleList_get(){}

/**
 * @OA\Post(
 *     path="/api/v1/ApiSaleController/addSale",
 *     summary="Add Sale",
 *     tags={"Sale"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 example={
                        "api_auth_key": "3f77867f-a014-48f8-9366-83440279a80c",
                        "customer_name": "Waziha Azhar",
                        "employee_name": "",
                        "total_items": "2",
                        "sub_total": "22",
                        "paid_amount": "22",
                        "previous_due": "0",
                        "due_amount": "0",
                        "disc": "0",
                        "disc_actual": "0",
                        "vat": "0",
                        "rounding": "0",
                        "total_payable": "22",
                        "total_item_discount_amount": "22",
                        "sub_total_with_discount": "22",
                        "sub_total_discount_amount": "22",
                        "total_discount_amount": "22",
                        "delivery_charge": "22",
                        "charge_type": "2",
                        "sub_total_discount_value": "2",
                        "sub_total_discount_type": "2",
                        "sale_date": "2",
                        "date_time": "2",
                        "grand_total": "2",
                        "delivery_partner_name": "2",
                        "delivery_status": "2",
                        "due_date_time": "2",
                        "account_note": "2",
                        "account_type": "2",
                        "sale_vat_objects": "[{'tax_field_name': 'CGST','tax_field_percentage': '20'},{'tax_field_name': 'SGST','tax_field_percentage': '20'},{'tax_field_name': 'IGST','tax_field_percentage': '20'},{'tax_field_name': 'Vat','tax_field_percentage': '20'}]",
                        "random_code": "2",
                        "note": "",
                        "order_date_time": "2",
                        "added_date": "2",
                        "outlet_name": "Mirpur",
                        "items": "[{'item_id': '2','quantity': '2','menu_price_without_discount': '2','menu_price_with_discount': '2','menu_unit_price': '2','purchase_price': '2','menu_vat_percentage': '2','menu_taxes': '2','menu_discount_value': '2','discount_type': '2','menu_note': '2','discount_amount': '2','item_type': '2','expiry_imei_serial': '2','sales_id': '2','is_promo_item': '2','promo_parent_id': '2','item_seller_id': '2','delivery_status': '2','loyalty_point_earn': '2'}]",
                        "payment_details": "[{'payment_name': 'Cash','currency_type': '','multi_currency': '','multi_currency_rate': '','amount': '','usage_point': '','sale_id': '','added_date': ''}]"
                    }
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function addSale_post() {}


/**
 * @OA\post(
 *     path="/api/v1/ApiSaleController/editSale",
 *     summary="Edit Sale",
 *     tags={"Sale"},
 *      @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 example={
 *                     "id": "1"
 *                 }
 *             )
 *         )
 *     ),
 *    @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function editSale_post(){}




/**
 * @OA\Post(
 *     path="/api/v1/ApiSaleController/updateSale",
 *     summary="Update Sale",
 *     tags={"Sale"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 example={
                        "id": "1",
                        "api_auth_key": "3f77867f-a014-48f8-9366-83440279a80c",
                        "customer_name": "Waziha Azhar",
                        "employee_name": "",
                        "total_items": "2",
                        "sub_total": "22",
                        "paid_amount": "22",
                        "previous_due": "0",
                        "due_amount": "0",
                        "disc": "0",
                        "disc_actual": "0",
                        "vat": "0",
                        "rounding": "0",
                        "total_payable": "22",
                        "total_item_discount_amount": "22",
                        "sub_total_with_discount": "22",
                        "sub_total_discount_amount": "22",
                        "total_discount_amount": "22",
                        "delivery_charge": "22",
                        "charge_type": "2",
                        "sub_total_discount_value": "2",
                        "sub_total_discount_type": "2",
                        "sale_date": "2",
                        "date_time": "2",
                        "grand_total": "2",
                        "delivery_partner_name": "2",
                        "delivery_status": "2",
                        "due_date_time": "2",
                        "account_note": "2",
                        "account_type": "2",
                        "sale_vat_objects": "[{'tax_field_name': 'CGST','tax_field_percentage': '20'},{'tax_field_name': 'SGST','tax_field_percentage': '20'},{'tax_field_name': 'IGST','tax_field_percentage': '20'},{'tax_field_name': 'Vat','tax_field_percentage': '20'}]",
                        "random_code": "2",
                        "note": "",
                        "order_date_time": "2",
                        "added_date": "2",
                        "outlet_name": "Mirpur",
                        "items": "[{'item_id': '2','quantity': '2','menu_price_without_discount': '2','menu_price_with_discount': '2','menu_unit_price': '2','purchase_price': '2','menu_vat_percentage': '2','menu_taxes': '2','menu_discount_value': '2','discount_type': '2','menu_note': '2','discount_amount': '2','item_type': '2','expiry_imei_serial': '2','sales_id': '2','is_promo_item': '2','promo_parent_id': '2','item_seller_id': '2','delivery_status': '2','loyalty_point_earn': '2'}]",
                        "payment_details": "[{'payment_name': 'Cash','currency_type': '','multi_currency': '','multi_currency_rate': '','amount': '','usage_point': '','sale_id': '','added_date': ''}]"
                    }
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function updateSale_post() {}


/**
 * @OA\Post(
 *     path="/api/v1/ApiSaleController/deleteSale",
 *     summary="Delete Sale",
 *     tags={"Sale"},
 *      @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 example={
 *                     "id": "1"
 *                 }
 *             )
 *         )
 *     ),
 *    @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No content"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Resource not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function deleteSale_post(){}





    public function set_swagger_config_get(){
        require("vendor/api/autoload.php");
        $openapi = \OpenApi\Generator::scan(['application/controllers/api/v1']);
        header('Content-Type: application/json');
        echo ($openapi->toJSON());
    } 
}