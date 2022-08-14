<?php

    class CRUD extends DB
    {
        //list method that will process customer list
        public function list()
        {
            //echo 'list';

            $db_connt = DB::connection();

            $sql = "SELECT * FROM customer ORDER BY id DESC";

            $result = $db_connt->query($sql);

            if($db_connt->error)
            {
                die('Error: '.$db_connt->error);
            }


            $i = 1;
            $list = [];

            //var_dump($result->num_rows);

            while ($row = $result->fetch_assoc())
            {
                $list[$i]['id']         = $row['id'];
                $list[$i]['name']       = $row['name'];
                $list[$i]['father']     = $row['father'];
                $list[$i]['mother']     = $row['mother'];
                $list[$i]['email']      = $row['email'];
                $list[$i]['phone']      = $row['phone'];
                $list[$i]['address']    = $row['address'];
                $list[$i]['entry_date'] = $row['entry_date'];
                $i++;
            }

            //var_dump($list);

            $db_connt->close();
            return json_encode(['success' => true, 'error_msg' => '', 'data' => compact('list')], 200);
        }

        //store method that will store customer info
        public function store()
        {
            //echo 'store';

            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {

                $name       = $_POST['name'];
                $father     = $_POST['father'];
                $mother     = $_POST['mother'];
                $email      = $_POST['email'];
                $phone      = $_POST['phone'];
                $address    = $_POST['address'];
                $name       = $_POST['name'];
                $entry_date = $_POST['entry_date'];

                $error = NULL;

                //form validation
                if(!preg_match('/^[a-zA-Z .]*$/',$name))
                {
                    $name_error="Name only consists of letters and  dot";
                    $error.=$name_error .' ';
                }

                if(!preg_match('/^[a-zA-Z .]*$/',$father))
                {
                    $father_error="Father name only consists of letters and  dot";
                    $error.=$father_error.' ';
                }

                if(!preg_match('/^[a-zA-Z .]*$/',$mother))
                {
                    $mother_error="Mother name only consists of letters and  dot";
                    $error.=$mother_error.' ';
                }

                if(!filter_var($email, FILTER_VALIDATE_EMAIL))
                {
                    $email_error="Email address not valid";
                    $error.=$email_error.' ';
                }

                if(!preg_match('/^[0-9]*$/',$phone))
                {
                    $phone_error="Phone number only consists of digits";
                    $error.=$phone_error.' ';
                }

                if(!preg_match('/^[a-zA-Z . , : # \/ ]*$/',$address))
                {
                    $address_error="Address only consists of latters, dot, comma, collon and backslash";
                    $error.=$address_error.' ';
                }

                list($y, $m, $d) = explode('-', $entry_date);

                if(!checkdate($m, $d, $y))
                {
                    $entry_date_error="Entry Date not valid";
                    $error.=$entry_date_error.' ';
                }

                if(!$error)
                {
                    $db_connt = DB::connection();

                    $sql = "INSERT INTO customer (name, father, mother, email, phone, address, entry_date) VALUES ('$name', '$father', '$mother', '$email', '$phone', '$address', '$entry_date')";
    
                    $result = $db_connt->query($sql);
    
                    if($db_connt->error)
                    {
                        die('Error: '.$db_connt->error);
                    }
    
                    $db_connt->close();
    
                    return json_encode(['success' => true, 'error_msg' => '', 'data' => ['success' => 'Data stored successfully']], 200);
                }
                return json_encode(['success' => false, 'error_msg' => 'Validation Error', 'data' => ['error' => $error]], 200);
            }
            return json_encode(['success' => false, 'error_msg' => '', 'data' => ['warning' => 'Only POST Method Allowed']], 200);
        }

        //edit method that will process customer info for edit
        public function edit()
        {
            //echo 'edit';

            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {

                $db_connt = DB::connection();

                $id = $_POST['id'];

                $sql = "SELECT * FROM customer WHERE id=$id ORDER BY id DESC";

                $result = $db_connt->query($sql);

                if($db_connt->error)
                {
                    die('Error: '.$db_connt->error);
                }


                $customer = [];
                if($result->num_rows > 0)
                {
                    $row = $result->fetch_assoc();
                    $customer['id']         = $row['id'];
                    $customer['name']       = $row['name'];
                    $customer['father']     = $row['father'];
                    $customer['mother']     = $row['mother'];
                    $customer['email']      = $row['email'];
                    $customer['phone']      = $row['phone'];
                    $customer['address']    = $row['address'];
                    $customer['entry_date'] = $row['entry_date'];
                }

                $db_connt->close();

                //var_dump($customer);
                return json_encode(['success' => true, 'error_msg' => '', 'data' => compact('customer')], 200);
               
            }
            return json_encode(['success' => false, 'error_msg' => '', 'data' => ['warning' => 'Only POST Method Allowed']], 200);
        }

        
        //update method that will update customer info
        public function update()
        {
            //echo 'update';

            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {

                $id         = $_POST['id'];
                $name       = $_POST['name'];
                $father     = $_POST['father'];
                $mother     = $_POST['mother'];
                $email      = $_POST['email'];
                $phone      = $_POST['phone'];
                $address    = $_POST['address'];
                $name       = $_POST['name'];
                $entry_date = $_POST['entry_date'];
                $error = NULL;

                //form validation
                if(!preg_match('/^[a-zA-Z .]*$/',$name))
                {
                    $name_error="Name only consists of letters and  dot";
                    $error.=$name_error .' ';
                }

                if(!preg_match('/^[a-zA-Z .]*$/',$father))
                {
                    $father_error="Father name only consists of letters and  dot";
                    $error.=$father_error.' ';
                }

                if(!preg_match('/^[a-zA-Z .]*$/',$mother))
                {
                    $mother_error="Mother name only consists of letters and  dot";
                    $error.=$mother_error.' ';
                }

                if(!filter_var($email, FILTER_VALIDATE_EMAIL))
                {
                    $email_error="Email address not valid";
                    $error.=$email_error.' ';
                }

                if(!preg_match('/^[0-9]*$/',$phone))
                {
                    $phone_error="Phone number only consists of digits";
                    $error.=$phone_error.' ';
                }

                if(!preg_match('/^[a-zA-Z . , : # \/ ]*$/',$address))
                {
                    $address_error="Address only consists of latters, dot, comma, collon and backslash";
                    $error.=$address_error.' ';
                }

                list($y, $m, $d) = explode('-', $entry_date);

                if(!checkdate($m, $d, $y))
                {
                    $entry_date_error="Entry Date not valid";
                    $error.=$entry_date_error.' ';
                }

                if(!$error)
                {
                    $db_connt = DB::connection();

                    $sql = "UPDATE customer SET name='$name', father='$father', mother='$mother', email='$email', phone='$phone', address='$address', entry_date='$entry_date' WHERE id=$id";

                    $result = $db_connt->query($sql);

                    if($db_connt->error)
                    {
                        die('Error: '.$db_connt->error);
                    }

                    $db_connt->close();

                    return json_encode(['success' => true, 'error_msg' => '', 'data' => ['success' => 'Data updated successfully']], 200);
                }
                return json_encode(['success' => false, 'error_msg' => 'Validation Error', 'data' => ['error' => $error]], 200);
            }
            return json_encode(['success' => false, 'error_msg' => '', 'data' => ['warning' => 'Only POST Method Allowed']], 200);
        }

        //destroy method that will delete customer info
        public function destroy()
        {
            //echo 'destroy';

            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {

                $id = $_POST['id'];

                $db_connt = DB::connection();

                $sql = "DELETE FROM customer WHERE id=$id";

                $result = $db_connt->query($sql);

                if($db_connt->error)
                {
                    die('Error: '.$db_connt->error);
                }
                
                $db_connt->close();

                return json_encode(['success' => true, 'error_msg' => '', 'data' => ['success' => 'Data deleted successfully']], 200);
            }
            return json_encode(['success' => false, 'error_msg' => '', 'data' => ['warning' => 'Only POST Method Allowed']], 200);
        }
    }