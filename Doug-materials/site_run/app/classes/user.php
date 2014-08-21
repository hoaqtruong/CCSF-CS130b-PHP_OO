<?php

    //class User extends Sqlite_Active_Record {
    class User extends SQLite_Active_Record {
        function save() {
            // Before we save the password, run sha1() if it has changed.
            if(strlen($this->password) != 40) {
                $this->password = sha1($this->password);
            }
            // Call the parent save() method.
            return parent::save();
        }
    }

