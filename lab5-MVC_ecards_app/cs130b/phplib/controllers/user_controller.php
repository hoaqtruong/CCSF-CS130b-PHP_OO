<?php

   class UserController extends ApplicationController {

      function __construct($request) {
         parent::__construct($request);
      }
      function index() {
         $this->for_view = 'Hello from the ' . __CLASS__ . ':' . __METHOD__;
      }

      function login() {
         print 'in' .  __CLASS__ . '::' . __METHOD__ ;
         $this->for_view = 'Hello from the ' . __CLASS__ . ':' . __METHOD__;
      }

   }
