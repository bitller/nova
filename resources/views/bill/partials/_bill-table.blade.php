<!-- BEGIN Bill table -->
<div class="panel panel-default" v-show="total !== '0.00'">
    <table class="table table-bordered table-condensed bill-products-table">
        <thead>
        <tr>
            <!-- BEGIN Page column -->
            <th class="text-center">
                <span data-toggle="tooltip" data-placement="top" title="{{ trans('bill.page_column_description') }}">
                    {{ trans('bill.page') }}
                </span>
            </th>
            <!-- END Page column -->

            <!-- BEGIN Code column -->
            <th class="text-center">
                <span data-toggle="tooltip" data-placement="top" title="{{ trans('bill.code_column_description') }}">
                    {{ trans('bill.code') }}
                </span>
            </th>
            <!-- END Code column -->

            <!-- BEGIN Name column -->
            <th class="text-center">
                <span data-toggle="tooltip" data-placement="top" title="{{ trans('bill.name_column_description') }}">
                    {{ trans('bill.name') }}
                </span>
            </th>
            <!-- END Name column -->

            <!-- BEGIN Quantity column -->
            <th class="text-center">
                <span data-toggle="tooltip" data-placement="top" title="{{ trans('bill.quantity_column_description') }}">
                    {{ trans('bill.quantity') }}
                </span>
            </th>
            <!-- END Quantity column -->

            <!-- BEGIN Price column -->
            <th class="text-center">
                <span data-toggle="tooltip" data-placement="top" title="{{ trans('bill.price_column_description') }}">
                    {{ trans('bill.price') }}
                </span>
            </th>
            <!-- END Price column -->

            <!-- BEGIN Discount column -->
            <th class="text-center" v-show="bill.show_discount_column">
                <span data-toggle="tooltip" data-placement="top" title="{{ trans('bill.discount_column_description') }}">
                    {{ trans('bill.discount') }}
                </span>
            </th>
            <!-- END Discount column -->

            <!-- BEGIN Final price column -->
            <th class="text-center" v-show="bill.show_discount_column">
                <span data-toggle="tooltip" data-placement="top" title="{{ trans('bill.final_price_column_description') }}">
                    {{ trans('bill.final_price') }}
                </span>
            </th>
            <!-- END Final price column -->

            <!-- BEGIN Delete column -->
            <th class="text-center hidden-print">
                <span data-toggle="tooltip" data-placement="top" title="{{ trans('bill.delete_column_description') }}">
                    {{ trans('common.delete') }}
                </span>
            </th>
            <!-- END Delete column -->
        </tr>
        </thead>
        <tbody>
        <tr v-repeat="product in bill.products">
            <td class="text-center editable"  v-on="click: editPage(product.page, product.id, product.code, product.bill_product_id)">
                <span v-show="product.page != '0'">@{{ product.page }}</span>
                <span v-show="product.page < 1">-</span>
            </td>
            <td class="text-center">@{{ product.code }}</td>
            <td class="text-center">@{{ product.name }}</td>
            <td class="text-center editable" v-on="click: editQuantity(product.quantity, product.id, product.code, product.bill_product_id)">@{{ product.quantity }}</td>
            <td class="text-center editable" v-on="click: editPrice(product.price, product.id, product.code, product.bill_product_id)">@{{ product.price }} ron</td>
            <td class="text-center editable" v-show="bill.show_discount_column" v-on="click: editDiscount(product.discount, product.id, product.code, product.bill_product_id)">@{{ product.discount }}% - @{{ product.calculated_discount }} ron</td>
            <td class="text-center" v-show="bill.show_discount_column">@{{ product.final_price }} ron</td>
            <td class="hidden-print text-center editabl delete-product"  v-on="click: deleteProduct(product.id, product.code, product.bill_product_id)"><span class="glyphicon glyphicon-trash"></span></td>
        </tr>

        </tbody>
    </table>
</div>
<!-- END Bill table -->