<!-- BEGIN Custom products tab content -->
<div id="custom-products-tab" class="tab-pane fade">

    <!-- BEGIN Custom products loader -->
    <div class="row text-center" v-show="loading_user_custom_products">
        <span class="glyphicon glyphicon-refresh glyphicon-spin tab-loader icon-color"></span>
    </div>
    <!-- END Custom products loader -->

    <!-- BEGIN Custom products of this user -->
    <div v-show="!loading_user_custom_products && custom_products.total > 0" class="dropdown">

        <h5 class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            <span id="user-email">{{ trans('users_manager.custom_products_of_this_user') }}</span><span class="caret"></span>
        </h5>

        <ul class="dropdown-menu">
            <!-- BEGIN Delete all user custom products -->
            <li v-show="custom_products.total > 0">
                <a href="#" v-on="click: deleteAllUserCustomProducts()">
                    <span class="glyphicon glyphicon-trash">&nbsp;</span> {{ trans('users_manager.delete_all_custom_products') }}
                </a>
            </li>
            <!-- END Delete all user custom products -->
        </ul>
    </div>
    <!-- END Custom products of this user -->

    <!-- BEGIN User custom products -->
    <div class="panel panel-default" v-show="!loading_user_custom_products && custom_products.total > 0">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th class="text-center">{{ trans('users_manager.product_code') }}</th>
                <th class="text-center">{{ trans('users_manager.product_name') }}</th>
                <th class="text-center">{{ trans('users_manager.make_official_product') }}</th>
                <th class="text-center">{{ trans('users_manager.delete_product') }}</th>
            </tr>
            </thead>
            <tbody>
            <tr v-repeat="custom_product in custom_products.data">
                <td class="text-center">@{{ custom_product.code }}</td>
                <td class="text-center">@{{ custom_product.name }}</td>
                <td v-on="click:makeCustomProductOfficial(custom_product.id)" class="text-center"><span class="glyphicon glyphicon-th"></span></td>
                <td v-on="click:deleteCustomProduct(custom_product.id)" class="text-center danger-hover"><span class="glyphicon glyphicon-trash"></span></td>
            </tr>
            </tbody>
        </table>
    </div>
    <!-- END User custom products -->

    <div v-show="custom_products.total < 1 && !loading_user_custom_products" class="alert alert-danger alert-top">{{ trans('users_manager.user_has_no_custom_products') }}</div>

</div>
<!-- END Custom products tab content -->