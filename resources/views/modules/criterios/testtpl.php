<ul {{options.ulClass}}>
    <li ng-repeat="node in node.{{options.nodeChildren}} | filter:filterExpression:filterComparator {{options.orderBy}}"
        ng-class="headClass(node)"
        {{options.liClass}}
        set-node-to-data>
        <i class="tree-branch-head" ng-class="iBranchClass()" ng-click="selectNodeHead(node)"></i>
        <i class="tree-leaf-head {{options.iLeafClass}}"></i>

        <i>
            <b>
                <div class="tree-label {{options.labelClass}}" ng-class="[selectedClass(), unselectableClass()]"
                     ng-click="selectNodeLabel(node)" tree-transclude></div>
            </b>
        </i>

        <treeitem ng-show="nodeExpanded()"></treeitem>

    </li>
</ul>