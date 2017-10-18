<?php

/**
 * Description of FilterComponent
 *
 * @author lucs morettilucas@hotmail.com
 */
class FilterComponent extends Component {

    /**
     * $this->request->data
     * @var type 
     */
    private $data = array();

    /**
     * $controller->modelClass
     * @var type 
     */
    private $modelClass = '';

    /**
     * $controller->modelClass
     * @var type 
     */
    private $paginate = '';

    /**
     * array de configuraciones
     * @param type $controller 
     */
    public $configuration = array();
    private $defaultJoin = array();
    private $joins = array();
    private $functions = array(
        'equal' => array(
            'operator' => '',
            'value' => '%s'
        ),
        'notEqual' => array(
            'operator' => '!=',
            'value' => '%s'
        ),
        'minor' => array(
            'operator' => '<',
            'value' => '%s'
        ),
        'minorEqual' => array(
            'operator' => '<=',
            'value' => '%s'
        ),
        'mayor' => array(
            'operator' => '>',
            'value' => '%s'
        ),
        'mayorEqual' => array(
            'operator' => '>=',
            'value' => '%s'
        ),
        'like' => array(
            'operator' => 'LIKE',
            'value' => '%%%s%%'
        ),
        'notLike' => array(
            'operator' => 'NOT LIKE',
            'value' => '%%%s%%'
        ),
        'between' => array(
            'operator' => 'BETWEEN ? AND ?',
            'value' => ''
        ),
        'multipleLike' => array(
            'operator' => 'OR',
            'value' => '',
        ),
    );

    /**
     * tiempo que aguante el filtro en sesión en segundos
     * @var type 
     */
    private $timeFilter = 36000; //10hs

    public function initialize(Controller $controller) {
        parent::initialize($controller);
        $this->operators = array(
            'equal' => __('Igual'),
            'notEqual' => __('Distinto'),
            'minor' => __('Menor'),
            'minorEqual' => __('Menor o Igual'),
            'mayor' => __('Mayor'),
            'mayorEqual' => __('Mayor o Igual'),
            'between' => __('Entre'),
        );
        $this->controller = $controller;
    }

    public function makeConditions() {
        $this->defaultJoin['type'] = 'INNER';
        $this->defaultJoin['conditions']['fk_in_this_table'] = $this->controller->modelClass . '.%s_id = %s.id';
        $this->defaultJoin['conditions']['fk_in_the_other_table'] = $this->controller->modelClass . '.id = %s.' . Inflector::underscore($this->controller->modelClass) . '_id';

        $this->paginate[$this->controller->modelClass] = $this->controller->paginate;

        $SessionName = 'FilterComponent.' . $this->controller->params['controller'] . '.' . $this->controller->params['action'];
        if (empty($this->controller->request->data)) {
            if ($this->controller->Session->check($SessionName)) {
                $data = $this->controller->Session->read($SessionName);
                if (time() - $data['__timeFilter'] < $this->timeFilter) {
                    $this->controller->request->data = $data;
                }
            }
        } else {
            $this->controller->Paginator->Controller->request->params['named']['page'] = 1;
        }
        if (isset($this->controller->request->data['__clean']) || !$this->controller->request->isAjax) {
            $this->controller->request->data = array();
        }
        $this->controller->request->data['__timeFilter'] = time();
        $this->controller->Session->write($SessionName, $this->controller->request->data);
        unset($this->controller->request->data['__timeFilter']);

        $this->__parseJoins();
        foreach ($this->controller->request->data as $model => $values) {
            foreach ($values as $name => $value) {
                $function = empty($this->configuration[$model][$name]['function']) ? 'equal' : $this->configuration[$model][$name]['function'];
                if ($function == 'custom') {
                    $function = $value['operator'];
                    unset($value['operator']);
                    if ($function != 'between') {
                        $value = $value['value'];
                    }
                }
                if ($this->checkValueEmptyness($value)) {
                    $this->addToJoin($model);
                    $this->paginate[$this->controller->modelClass]['conditions'][$this->__makeName($model, $name, $function)] = $this->__makeValue($model, $name, $value, $function);
                }
            }
        }
        $this->paginate[$this->controller->modelClass]['joins'] = array_values($this->joins);
        $this->controller->Paginator->settings = $this->paginate;
    }

    /**
     * agrego los joins que ya están hechos desde el controlador:) 
     */
    private function __parseJoins() {
        if (isset($this->controller->Paginator->settings[$this->controller->modelClass]['joins'])) {
            foreach ($this->controller->Paginator->settings[$this->controller->modelClass]['joins'] as $join) {
                $this->joins[$join['alias']] = $join;
            }
        }
    }

    /**
     * agrega un join necesario si este no existia
     * @param type $model 
     */
    private function addToJoin($model) {
        if ($model != $this->controller->modelClass && !in_array($model, array_keys($this->joins))) {
            if (empty($this->configuration[$model]['join']['table'])) {
                $this->joins[$model]['table'] = Inflector::tableize($model);
            } else {
                $this->joins[$model]['table'] = $this->configuration[$model]['join']['table'];
            }
            if (empty($this->configuration[$model]['join']['alias'])) {
                $this->joins[$model]['alias'] = $model;
            } else {
                $this->joins[$model]['alias'] = $this->configuration[$model]['join']['alias'];
            }
            if (empty($this->configuration[$model]['join']['type'])) {
                $this->joins[$model]['type'] = $this->defaultJoin['type'];
            } else {
                $this->joins[$model]['type'] = $this->configuration[$model]['join']['type'];
            }
            if (empty($this->configuration[$model]['join']['conditions'])) {
                $this->joins[$model]['conditions'][] = sprintf($this->defaultJoin['conditions']['fk_in_this_table'], Inflector::singularize(Inflector::underscore($model)), $model);
            } elseif ($this->configuration[$model]['join']['conditions'] == 'fk_in_this_table') {
                $this->joins[$model]['conditions'][] = sprintf($this->defaultJoin['conditions']['fk_in_this_table'], Inflector::singularize(Inflector::underscore($model)), $model);
            } elseif ($this->configuration[$model]['join']['conditions'] == 'fk_in_the_other_table') {
                $this->joins[$model]['conditions'][] = sprintf($this->defaultJoin['conditions']['fk_in_the_other_table'], $model);
            } else {
                $this->joins[$model]['conditions'] = $this->configuration[$model]['join']['conditions'];
            }
        }
    }

    private function __makeName($model, $name, $function = 'equal') {
        $function_name = "__{$function}Name";
        if (method_exists($this, $function_name)) {
            return $this->$function_name($model, $name, $function);
        }
        $operator = empty($this->functions[$function]['operator']) ? '' : ' ' . $this->functions[$function]['operator'];
        return "{$model}.{$name}{$operator}";
    }

    private function __makeValue($model, $name, $value, $function = 'equal') {
        $function_name = "__{$function}Value";
        if (method_exists($this, $function_name)) {
            return $this->$function_name($model, $name, $value, $function);
        }
        return is_array($value) ? $value : sprintf($this->functions[$function]['value'], $value);
    }

    public function beforeRender(Controller $controller) {
        parent::beforeRender($controller);
        $controller->set('filterOperators', $this->operators);
    }

    private function checkValueEmptyness($value) {
        if (is_array($value)) {
            foreach ($value as $val) {
                if (empty($val)) {
                    return false;
                }
            }
        }
        return !empty($value);
    }

    private function getModel($model) {
        return ClassRegistry::init($model);
    }

    private function __multipleLikeName($model, $name, $function) {
        return 'OR';
    }

    private function __multipleLikeValue($model, $name, $value, $function) {
        $return = array();
        foreach (explode(' ', $value) as $val) {
            foreach ($this->configuration[$model][$name]['fields'] as $field) {
                $field = strpos($field, '.') === false ? $model . '.' . $field : $field;
                $return[] = "{$field} LIKE '%{$val}%'";
            }
        }
        return $return;
    }

}
