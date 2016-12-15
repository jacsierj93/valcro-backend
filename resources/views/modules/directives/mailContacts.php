<div layout="column" class="mail-contacts"  >
    <div flex layout="row"  layout-align="end start" class="mail-option">
        <div  ng-show="cc" layout="row" ng-click="showCc = !showCc ; showHead = true ;"   ng-class="{'mail-option-select': (showCc) }">
            Cc
        </div>
        <div layout="row"   ng-show="ccb" ng-click="showCco = !showCco ;showHead = true ; "  ng-class="{'mail-option-select': (showCco) }">
            Cco
        </div>
    </div>
    <div layout="column" layout-align="center start">
        <md-chips ng-model="to"
                  required
                  md-transform-chip="transformChip($chip)"
                  style="height: inherit;"
                  md-on-add =" addEmail($chip,'to') "
                  md-on-remove ="removeEmail($chip) "
                  skitp-tab
                  flex
                  ng-show="to"

        >
            <md-autocomplete
                md-search-text="searchTo"
                md-items="item in all() | filter : searchTo | customFind : destinos : isAddMail "
                md-item-text="item.nombre"
                placeholder="Para:">
                <span >{{item.nombre}}/{{item.correo}}</span>
            </md-autocomplete>
            <md-chip-template>
                <strong>{{$chip.nombre}}/{{$chip.correo}} </strong>
            </md-chip-template>
        </md-chips>

        <md-chips ng-model="cc"
                  required
                  md-transform-chip="transformChip($chip)"
                  style="height: inherit;"
                  md-on-add =" addEmail($chip,'cc') "
                  md-on-remove ="removeEmail($chip) "
                  skitp-tab
                  ng-show="cc"

        >
            <md-autocomplete
                md-search-text="searchCc"
                md-items="item in all() | filter : searchCc | customFind : destinos : isAddMail "
                md-item-text="item.nombre"
                placeholder="Cc:">
                <span >{{item.nombre}}/{{item.correo}}</span>
            </md-autocomplete>
            <md-chip-template>
                <strong>{{$chip.nombre}}/{{$chip.correo}} </strong>
            </md-chip-template>
        </md-chips>
        <md-chips ng-model="ccb"
                  required
                  md-transform-chip="transformChip($chip)"
                  style="height: inherit;"
                  md-on-add =" addEmail($chip,'ccb') "
                  md-on-remove ="removeEmail($chip) "
                  skitp-tab
                  ng-show="ccb"

        >
            <md-autocomplete
                md-search-text="searchCcb"
                md-items="item in all()  | filter : searchCcb | customFind : destinos : isAddMail "
                md-item-text="item.nombre"
                placeholder="Ccb:">
                <span >{{item.nombre}}/{{item.correo}}</span>
            </md-autocomplete>
            <md-chip-template>
                <strong>{{$chip.nombre}}/{{$chip.correo}} </strong>
            </md-chip-template>
        </md-chips>

        <md-input-container class="md-block"  >
            <label style="width: calc(100% - 4px );">Asunto</label>
            <md-autocomplete md-selected-item="subject"
                             info="Asunto del correo"
                             required
                             skip-tab
                             md-search-text="asunto"
                             md-items="item in asuntos"
                             md-item-text="item"
                             md-no-asterisk
                             md-min-length="0"
                             md-no-cache="true"
                             vl-no-clear
            >
                <md-item-template>
                    <span>{{item}}</span>
                </md-item-template>
            </md-autocomplete>
        </md-input-container>
    </div>
</div>