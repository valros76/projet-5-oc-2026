<?php
    class PropertyNotFoundException extends Exception
    {
        private $_className;
		private $_property;

        public function __construct($className,$property,$message = "Propriété manquante.")
        {
			$this->_className = $className;
            $this->_property = $property;
            parent::__construct($message,'0004');
        }

        public function getMoreDetail()
        {
            return "La propriété {$this->_property} n'existe pas dans la classe {$this->_className}.";
        }
    }