<!-- 1) ########################################## CONTENEDOR GENERAL DE LA SECCION ########################################## -->
<div layout="column" class="md-whiteframe-1dp" flex ng-controller="mainUsersController as ctrl" global>
    <!-- 5) ########################################## AREA CONTENEDORA DE LA INFOMACION ########################################## -->
    <div class="contentHolder" layout="row" flex>

<!--        <div class="barraLateral" layout="column" ng-controller="listUsersController">-->
        <div class="barraLateral" layout="column">
            <div id="menu" layout="column" class="menu_shadow" style="height: 48px; overflow: hidden; background-color: #f1f1f1; min-height: 48px;">
                <!-- 3) ########################################## MENU ########################################## -->
                <div class="menu" style="min-height: 48px; width: 100%;">
                    <div style="width: calc(100% - 16px); text-align: center; padding-top: 8px; height: 16px;">
                        Menu
                    </div>
                    <div style="width: calc(100% - 16px); height: 24px; cursor: pointer; text-align: center;"
                         ng-click="FilterLateral()" ng-hide="showLateralFilter">
                        <img ng-src="images/Down.png">
                        <!--<span class="icon-Down" style="font-size: 24px; width: 24px; height: 24px;" ></span>-->
                    </div>
                </div>
                <div layout="column" flex="" tabindex="-1"  style="padding: 0px 4px 0px 4px;">
                    <form name="provdiderFilter" tabindex="-1">
                        <div class="menuFilter" id="expand1" style="height: 176px;" layout-align="start start" tabindex="-1">
                            <div>
                                <!--ADAPTAR PARA FILTRAR USUARIOS ACTIVOS E INACTIVOS-->
                                <!--<span class="icon-Contrapedidos iconInput" tab-index="-1" ng-click="togglecheck($event, 'contraped')" ng-class="{'iconActive':filterProv.contraped == '1','iconInactive':filterProv.contraped == '0'}" style="font-size:23px;margin-rigth:8px"></span>
                                <span class="icon-Aereo" style="font-size: 23px" ng-click="togglecheck($event, 'aereo')" ng-class="{'iconActive':filterProv.aereo == '1','iconInactive':filterProv.aereo == '0'}" ></span>
                                <span class="icon-Barco" style="font-size: 23px" ng-click="togglecheck($event, 'maritimo')" ng-class="{'iconActive':filterProv.maritimo == '1','iconInactive':filterProv.maritimo == '0'}" /></span>-->
                            </div>
                            <md-input-container class="md-block" style="width: calc(100% - 16px); height: 24px;">
                                <label>Usuario</label>
                                <!--PENDIENTE COLOCAR ADAPTAR FILTRO PARA USURIO-->
                                <!--<input  type="text" ng-model="filterProv.razon_social"  tabindex="-1" >-->
                            </md-input-container>
                            <md-input-container class="md-block" style="width: calc(100% - 16px); height: 24px;">
                                <label>Sucursal</label>
                                <!--PENDIENTE ADAPTAR PARA FILTRAR USURIOS POR SUCURSAL-->
                                <!--<input  type="text" ng-model="filterProv.pais"  tabindex="-1" >-->
                            </md-input-container>
                        </div>
                    </form>
                    <div id="expand2" flex >

                    </div>
                    <div style="width: calc(100% - 16px); height: 24px; cursor: pointer; text-align: center;" ng-click="FilterLateral()">
                       <!-- <img ng-src="{{imgLateralFilter}}">-->
                        <span class="icon-Up" style="font-size: 24px; width: 24px; height: 24px; color:#ccc" ></span>
                        <!--<span class="icon-Down" style="font-size: 24px; width: 24px; height: 24px;" ></span>-->
                    </div>
                </div>
            </div>

            <!-- 6) ########################################## LISTADO LATERAL ########################################## -->
            <div id="launchList" style="width:0px;height: 0px;" tabindex="-1" list-box></div>
            <div id="listado" flex  style="overflow-y:auto;" ng-click="showAlert(45)" >
                <!-- 7) ########################################## ITEN A REPETIR EN EL LISTADO DE PROVEEDORES ########################################## -->
                <div class="boxList"  layout="column" list-box flex ng-repeat="item in users" ng-click="seltUser(item)" ng-class="{'listSel' : (item.id == userSelected.id)}">
                    <div style="overflow: hidden; text-overflow: ellipsis;" flex>{{item.nombre}}</div>
                    <div style="overflow: hidden; text-overflow: ellipsis;" flex>{{item.apellido}}</div>
                    <div style="overflow: hidden; text-overflow: ellipsis;" flex>{{item.user}}</div>

                    <div style="height:40px;">

                    </div>
                </div>
            </div>
            <!--</md-content>-->
        </div>


        <!--######################################## INICIO DEL MODULO #########################################-->
        <div layout="column" flex class="md-whiteframe-1dp">
            <!-- 4) ########################################## BOTONERA ########################################## -->
            <div class="botonera" layout layout-align="start center">
                <div layout="column" layout-align="center center">

                </div>
                <div layout="column" layout-align="center center" ng-click="openForm()">
                    <!--<i class="fa fa-plus"></i>-->
                    <span class="icon-Agregar" style="font-size: 23px"></span>
                    <?/*= HTML::image("images/agregar.png") */?>
                </div>
                <div layout="column" layout-align="center center" ng-click="openForm(userSelected.id)" ng-show="userSelected.id">
                    <span class="icon-Actualizar" style="font-size: 23px"></span>
                    <!-- --><?/*= HTML::image("images/actualizar.png") */?>
                </div>
                <div layout="column" layout-align="center center" ng-click="showAlert()" ng-show="userSelected.id">
                    <span class="icon-Eliminar" style="font-size: 23px"></span>
                    <?/*= HTML::image("images/Eliminar.png") */?>
                </div>

            </div>

            <div flex layout="row">
                <!-- 8) ########################################## BOTON REGRESAR ########################################## -->
                <div style="width: 48px; background-color: #ffffff;" layout="column" layout-align="center center">
                    <!--<i class="fa fa-angle-left" style="font-size: 48px; color: #999999;"></i>-->
                    <?= HTML::image("images/btn_prevArrow.png", "", array("ng-click" => "prevLayer()", "ng-show" => "(index>0)", "style" => "cursor:pointer")) ?>
                </div>

                <!-- 9) ########################################## AREA CARGA DE LAYERS ########################################## -->
                <div class="loadArea" ng-class="{'loading':list2() == 0}" layout="column" layout-align="center center" flex style="color: rgba(0,0,0,0.22);">
                    <div style="width: 96px; height: 96px; border-radius: 50%; border: 1px solid rgba(0,0,0,0.22); font-size: 72px; text-align: center; font-weight: 100; ">
                        US
                    </div>
                    <br> Selecciones un Usuario
                </div>
            </div>
        </div>


        <md-sidenav layout="row" style="margin-top:96px; margin-bottom:48px; width: calc(100% - 312px);" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="userLayer3" id="userLayer3">
<!--            <md-content class="cntLayerHolder" layout="column" layout-align="start none" layout-padding flex ng-controller="userForm as ctrl">-->
                <md-content class="cntLayerHolder" layout="column" layout-align="start none" layout-padding flex>
                <!--############## FORMULARIO DE INFORMACION DEL USUARIO ##########################-->
                <form name="userInfoForm" layout="row" global ng-class="{'focused':isShow}" ng-disabled="true" ng-click="isShow = true" click-out="isShow = false; userInfoForm.$setUntouched()">
                    <div active-left></div>
                    <div flex layout="column">
                        <div class="titulo_formulario" layout="column" layout-align="start start">
                            <div>
                                Usuarios
                            </div>
                        </div>
                        <div flex layout="column" class="area-form">
                            <div class="row" layout="row">
                                <md-input-container class="md-block" flex>
                                    <label>Nombres</label>
                                    <input skip-tab
                                           id="userNomb"
                                           ng-change="validar()"
                                           ng-model="userSelected.usr_nombre"
                                           info="Ingrese el nombre del Usuario"
                                           autocomplete="off"
                                           field="nombre_usr"
                                           name="nombre_usr"
                                           maxlength="80"
                                           ng-minlength="3"
                                           required
                                           md-no-asterisk>
                                </md-input-container>

                                <md-input-container class="md-block" flex>
                                    <label>Apellidos</label>
                                    <input skip-tab
                                           ng-model="userSelected.usr_apellido"
                                           ng-change="validar()"
                                           info="Ingrese el apellido del Usuario"
                                           autocomplete="off"
                                           field="apellido_usr"
                                           name="apellido_usr"
                                           maxlength="80"
                                           ng-minlength="3"
                                           required
                                           md-no-asterisk>
                                </md-input-container>

                                <md-input-container class="md-block" flex>
                                    <label>Cargo</label>
                                    <md-autocomplete flex
                                                     required
                                                     skip-tab
                                                     md-no-asterisk
                                                     id="cargos"
                                                     model="userSelected.crg_id"
                                                     info="seleccione el cargo que desempeña el usuarios"
                                                     md-require-match="true"
                                                     md-no-cache="ctrl.noCache"
                                                     md-search-text="ctrl.searchCargo"
                                                     md-selected-item="ctrl.selectedCargo"
                                                     md-items="item in ctrl.cargos  | stringKey : ctrl.searchCargo : 'nombre'"
                                                     md-item-text="item.nombre"
                                                     md-min-length="0">
                                        <md-item-template>
                                            <span md-highlight-text="ctrl.searchCargo" md-highlight-flags="^i">{{item.nombre}}</span>
                                        </md-item-template>
                                        <md-not-found>
                                            <div ng-click="nvoCargo(ctrl.searchCargo)">El cargo <span style="color:#99000;">"{{ctrl.searchCargo}}"</span> no existe,
                                            ¿Desea crearlo?</div>
                                        </md-not-found>
                                    </md-autocomplete>
                                </md-input-container>
 
                            </div>

                            <div class="row" layout="row">

                                <md-input-container class="md-block" flex>
                                    <label>Email</label>
                                    <input skip-tab
                                           ng-model="userSelected.email"
                                           ng-change="validEmail(userSelected.email)"
                                           info="Inserte el email a donde recibira las comunicacion el usuario"
                                           autocomplete="off"
                                           field="email_usr"
                                           name="email_usr"
                                           maxlength="80"
                                           ng-minlength="3"
                                           required
                                           md-no-asterisk>
                                </md-input-container>

                                <md-input-container class="md-block" flex>
                                    <label>Codigo Profit</label>
                                    <input skip-tab
                                           ng-model="userSelected.co_us"
                                           ng-change="validar()"
                                           info="Escriba el codigo del usuario en profit"
                                           autocomplete="off"
                                           field="prft_code_usr"
                                           name="prft_code_usr"
                                           maxlength="80"
                                           ng-minlength="3"
                                           md-no-asterisk>
                                </md-input-container>

                            </div>

                            <div class="row" layout="row">
                                <md-input-container class="md-block" flex>
                                    <label>Responsabilidades</label>
                                    <input skip-tab
                                           ng-model="userSelected.responsabilidades"
                                           ng-change="validar()"
                                           info="Indique las labores que desempeña el usuarios"
                                           autocomplete="off"
                                           field="responsabilidad_usr"
                                           name="responsabilidad_usr"
                                           maxlength="80"
                                           ng-minlength="3"
                                           md-no-asterisk>
                                </md-input-container>
                            </div>
                        </div>
                    </div>
                </form>

                <!--################ FORMULARIO DE ACCESO ####################-->
                <form name="userAccesForm" layout="row" global ng-class="{'focused':isShow}" ng-disabled="true" ng-click="isShow = true" click-out="isShow = false; userAccesForm.$setUntouched()">
                    <div active-left></div>
                    <div flex layout="column">
                        <div class="titulo_formulario" layout="column" layout-align="start start">
                            <div>
                                Datos de Acceso
                            </div>
                        </div>
                        <div flex layout="column" class="area-form">
                            <div class="row" layout="row">

                                <md-input-container class="md-block" flex>
                                    <label>Usuario</label>
                                    <input skip-tab
                                           ng-model="userSelected.user"
                                           ng-change="validar()"
                                           info="Ingrese el nombre de acceso"
                                           autocomplete="off"
                                           field="usuario_usr"
                                           name="usuario_usr"
                                           maxlength="80"
                                           ng-minlength="3"
                                           required
                                           md-no-asterisk
                                           >
                                </md-input-container>

                                <md-input-container class="md-block" flex>
                                    <label>Clave</label>
                                    <input skip-tab
                                           type="password"
                                           ng-model="userSelected.password"
                                           info="Ingrese la clave de acceso"
                                           autocomplete="off"
                                           field="clave_usr"
                                           name="clave_usr"
                                           maxlength="80"
                                           ng-minlength="3"
                                           required
                                           md-no-asterisk
                                           >
                                </md-input-container>
                                
                                <md-input-container class="md-block" flex>
                                    <label>Nivel de acceso</label>                                   
                                    <md-autocomplete flex
                                                     required
                                                     skip-tab
                                                     md-no-asterisk
                                                     id="niveles"
                                                     model="userSelected.nvl_id"
                                                     md-require-match="true"
                                                     info="Seleccione el nivel o rango de permiso que tebdra el usuario"
                                                     md-no-cache="ctrl.noCache"
                                                     md-search-text="ctrl.searchNivel"
                                                     md-selected-item="ctrl.selectedNivel"
                                                     md-items="item in ctrl.niveles | stringKey : ctrl.searchNivel : 'nombre'"
                                                     md-item-text="item.nombre"
                                                     md-min-length="0">                                        
                                        <md-item-template>
                                            <span md-highlight-text="ctrl.searchNivel" md-highlight-flags="^i">{{item.nombre}}</span>
                                        </md-item-template>
                                        <md-not-found>
                                            <div ng-click="ctrl.nvoNivel(ctrl.searchNivel)">El cargo <span style="color:#99000;">"{{ctrl.searchNivel}}"</span> no existe,
                                            ¿Desea crearlo?</div>
                                        </md-not-found>
                                    </md-autocomplete>
                                </md-input-container>

                                <md-input-container class="md-block" flex>
                                    <label>Estatus</label>
                                    <md-autocomplete flex
                                                     required
                                                     skip-tab
                                                     md-no-asterisk
                                                     id="estatus"
                                                     model="userSelected.status"
                                                     md-require-match="true"
                                                     info="Indique si el usuario esta activo o no"
                                                     md-no-cache="ctrl.noCache"
                                                     md-search-text="ctrl.searchEstatus"
                                                     md-selected-item="ctrl.selectedEstatus"
                                                     md-items="item in ctrl.estatus | stringKey : ctrl.searchEstatus : 'nombre'"
                                                     md-item-text="item.nombre"
                                                     md-min-length="0">                                        
                                        <md-item-template>
                                            <span md-highlight-text="ctrl.searchEstatus" md-highlight-flags="^i">{{item.nombre}}</span>
                                        </md-item-template>
                                        <md-not-found>
                                            <div ng-click="ctrl.nvoEstatus(ctrl.searchEstatus)">El cargo <span style="color:#99000;">"{{ctrl.searchEstatus}}"</span> no existe,
                                            ¿Desea crearlo?</div>
                                        </md-not-found>
                                    </md-autocomplete>
                                </md-input-container>

                            </div>
                        </div>
                    </div>
                </form>
            </md-content>
            <show-next on-next="saveForm1"></show-next>
        </md-sidenav>


    </div>




    <next-row></next-row>
    <div id="blockSection" style="position: absolute;height: 100%;width: 100%;top: 0px;left: 0px;z-index: 89;background: rgba(255,255,255,0.2);cursor: default;" ng-show="secBlock" ng-show="list2() == 0"></div>
    <div ng-controller="notificaciones" ng-include="template"></div>

</div>