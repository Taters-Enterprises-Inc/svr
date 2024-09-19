<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Svr extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('excel');
        $this->load->database();
    }

    public function index()
    {
        if ($this->session->has_userdata('is_login')) {
            $this->load->view('generate_svr_form');
        } else {
            redirect('/');
        }
    }

    public function generate()
    {
        // echo "Working!";
        // die();

        ini_set("soap.wsdl_cache_enabled", "0");
        $client = new SoapClient("http://tei.alliancewebpos.com/appserv/app/w3p/w3p.wsdl", array("location" => "http://tei.alliancewebpos.com/appserv/app/w3p/W3PSoapServer.php"));

        $fromDate = str_replace('-', '', $this->input->post('fromDate'));
        $toDate = str_replace('-', '', $this->input->post('toDate'));

        if (empty($fromDate) || empty($toDate)) {
            redirect('/generate');
        }

        // Start of Cashier Declaration
        $cashier_declaration_array = array();
        
        $cashier_fnew_batchid_value = "";
        $cashier_flast_key_value = "";
        $cashier_fdone_value = 0;
        $cashier_flast_key_value_array = array();

        // $cashier_declaration_for_sales_trans_getsum = array();
        
        $cashier_p = 
        "<root>
            <id>
                <fw3p_id>22020882</fw3p_id>
                <fw3p_key>12345</fw3p_key>
            </id>
            <data>
                <filter>
                    <ffrom>$fromDate</ffrom>
                    <fto>$toDate</fto>
                    <fnew_batchid></fnew_batchid>
                    <flast_batchid/>
                    <flast_key></flast_key>
                </filter>
            </data>
        </root>";

        // Make the SOAP call
        $cashier_response = $client->call("GET_CASHIER_DECLARATION", $cashier_p);

        // Parse the response as XML
        $cashier_xml = simplexml_load_string($cashier_response);

        foreach ($cashier_xml->data as $cashier_data) {
            $cashier_fnew_batchid_value = $cashier_data->fnew_batchid;
            $cashier_flast_key_value = $cashier_data->flast_key;
            $cashier_flast_key_value_array[] = $cashier_data->flast_key;
            $cashier_declaration_array[] = $cashier_data->record;
        }

        while ($cashier_fdone_value != 1) {
            $cashier_p1 = 
            "<root>
                <id>
                    <fw3p_id>22020882</fw3p_id>
                    <fw3p_key>12345</fw3p_key>
                </id>
                <data>
                    <filter>
                        <ffrom>$fromDate</ffrom>
                        <fto>$toDate</fto>
                        <fnew_batchid>$cashier_fnew_batchid_value</fnew_batchid>
                        <flast_batchid/>
                        <flast_key>$cashier_flast_key_value</flast_key>
                    </filter>
                </data>
            </root>";

            // Make the SOAP call
            $cashier_response1 = $client->call("GET_CASHIER_DECLARATION", $cashier_p1);

            // Parse the response as XML
            $cashier_xml1 = simplexml_load_string($cashier_response1);

            foreach ($cashier_xml1->data as $cashier_data1) {
                $cashier_flast_key_value = $cashier_data1->flast_key;
                $cashier_flast_key_value_array[] = $cashier_data1->flast_key;

                if ($cashier_data1->fdone == 1) {
                    $cashier_fdone_value = 1;
                }
            }
        }

        foreach ($cashier_flast_key_value_array as $cashier_flast_key_value_updated) {
            $cashier_p2 = 
            "<root>
                <id>
                    <fw3p_id>22020882</fw3p_id>
                    <fw3p_key>12345</fw3p_key>
                </id>
                <data>
                    <filter>
                        <ffrom>$fromDate</ffrom>
                        <fto>$toDate</fto>
                        <fnew_batchid>$cashier_fnew_batchid_value</fnew_batchid>
                        <flast_batchid/>
                        <flast_key>$cashier_flast_key_value_updated</flast_key>
                    </filter>
                </data>
            </root>";

            // Make the SOAP call
            $cashier_response2 = $client->call("GET_CASHIER_DECLARATION", $cashier_p2);

            // Parse the response as XML
            $cashier_xml2 = simplexml_load_string($cashier_response2);

            foreach ($cashier_xml2->data as $cashier_data2) {
                $cashier_declaration_array[] = $cashier_data2->record;
            }
        }
        // End of Cashier Declaration

        $sales_trans_array = array();
        
        $fnew_batchid_value = "";
        $flast_key_value = "";
        $fdone_value = 0;
        $flast_key_value_array = array();
        
        $p = 
        "<root>
            <id>
                <fw3p_id>22020882</fw3p_id>
                <fw3p_key>12345</fw3p_key>
            </id>
            <data>
                <filter>
                    <ffrom>$fromDate</ffrom>
                    <fto>$toDate</fto>
                    <fnew_batchid></fnew_batchid>
                    <flast_batchid/>
                    <flast_key></flast_key>
                </filter>
            </data>
        </root>";

        // Make the SOAP call
        $response = $client->call("GET_SALES_TRANSACTION", $p);

        // Parse the response as XML
        $xml = simplexml_load_string($response);

        foreach ($xml->data as $data) {
            $fnew_batchid_value = $data->fnew_batchid;
            $flast_key_value = $data->flast_key;
            $flast_key_value_array[] = $data->flast_key;
            $sales_trans_array[] = $data;
        }

        while ($fdone_value != 1) {
            $p1 = 
            "<root>
                <id>
                    <fw3p_id>22020882</fw3p_id>
                    <fw3p_key>12345</fw3p_key>
                </id>
                <data>
                    <filter>
                        <ffrom>$fromDate</ffrom>
                        <fto>$toDate</fto>
                        <fnew_batchid>$fnew_batchid_value</fnew_batchid>
                        <flast_batchid/>
                        <flast_key>$flast_key_value</flast_key>
                    </filter>
                </data>
            </root>";

            // Make the SOAP call
            $response1 = $client->call("GET_SALES_TRANSACTION", $p1);

            // Parse the response as XML
            $xml1 = simplexml_load_string($response1);

            foreach ($xml1->data as $data1) {
                $flast_key_value = $data1->flast_key;
                $flast_key_value_array[] = $data1->flast_key;

                if ($data1->fdone == 1) {
                    $fdone_value = 1;
                }
            }
        }

        foreach ($flast_key_value_array as $flast_key_value_updated) {
            $p2 = 
            "<root>
                <id>
                    <fw3p_id>22020882</fw3p_id>
                    <fw3p_key>12345</fw3p_key>
                </id>
                <data>
                    <filter>
                        <ffrom>$fromDate</ffrom>
                        <fto>$toDate</fto>
                        <fnew_batchid>$fnew_batchid_value</fnew_batchid>
                        <flast_batchid/>
                        <flast_key>$flast_key_value_updated</flast_key>
                    </filter>
                </data>
            </root>";

            // Make the SOAP call
            $response2 = $client->call("GET_SALES_TRANSACTION", $p2);

            // Parse the response as XML
            $xml2 = simplexml_load_string($response2);

            foreach ($xml2->data as $data2) {
                $sales_trans_array[] = $data2;
            }
        }

        // echo "<pre>";
        // print_r($sales_trans_array);
        // echo "</pre>";
        // die();

        $sales_test_array = array();

        foreach ($sales_trans_array as $st) {
            foreach ($st->record as $record_wew) {
                $sales_test_array[] = $record_wew;
                
                $t_fsaledate = $record_wew->fsale_date;
                $t_fcashiername = $record_wew->fcashier_name;
                $t_ftermid = $record_wew->ftermid;
                $t_fcredit = $record_wew->fcredit;
                $t_fscdiscount = $record_wew->fscdiscount;
                $t_fpwd_discount = $record_wew->fpwd_discount;
                $t_ftotal_discount = $record_wew->ftotal_discount;
                $t_fdocument_no = $record_wew->fdocument_no;

                foreach ($record_wew->payment as $key => $payment_wew) {
                    $t_finfo2 = $payment_wew->finfo2;
                    $t_famount = $payment_wew->famount;

                    $data_for_insert = array(
                        'fsale_date' => $t_fsaledate,
                        'fcashier_name' => $t_fcashiername,
                        'ftermid' => $t_ftermid,
                        'fcredit' => $t_fcredit,
                        'finfo2' => $t_finfo2,
                        'famount' => $t_famount,
                        'fscdiscount' => $t_fscdiscount,
                        'fpwd_discount' => $t_fpwd_discount,
                        'ftotal_discount' => $t_ftotal_discount,
                        'fdocument_no' => $t_fdocument_no,
                    );
                    $this->db->insert('parent_tb', $data_for_insert);
                }
            }
        }

        // echo "Working!";
        // die();

        // Initialize the PHPExcel object
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet()->setTitle('Sales Transaction');

        // Set headers in the Excel sheet
        $headers = [
            'A1' => 'fsale_date',
            'B1' => 'fsale_time',
            'C1' => 'fzcounter',
            'D1' => 'ftermid',
            'E1' => 'fdocument_no',
            'F1' => 'faccountid',
            'G1' => 'faccount_name',
            'H1' => 'fthirdparty_accountid',
            'I1' => 'fsiteid',
            'J1' => 'fofficeid',
            'K1' => 'ftotal_discount',
            'L1' => 'fline_discount',
            'M1' => 'fscdiscount',
            'N1' => 'fpwd_discount',
            'O1' => 'fdip_discount',
            'P1' => 'fgross',
            'Q1' => 'flocal_tax',
            'R1' => 'famusement_tax',
            'S1' => 'frefund',
            'T1' => 'fservice_charge',
            'U1' => 'fsubtotal',
            'V1' => 'ftax',
            'W1' => 'ftax_sale',
            'X1' => 'fnotax_sale',
            'Y1' => 'fzero_rated_sale',
            'Z1' => 'fcash',
            'AA1' => 'fcharge',
            'AB1' => 'fcredit',
            'AC1' => 'fcheck',
            'AD1' => 'fothers',
            'AE1' => 'fevat',
            'AF1' => 'fvat_exempt',
            'AG1' => 'fewt',
            'AH1' => 'fcustomer_count',
            'AI1' => 'fcashier_name',
            'AJ1' => 'fcashierid',
            'AK1' => 'fposted_date',
            'AL1' => 'fupdated_date',
            'AM1' => 'fcreated_date',
            'AN1' => 'fserviced_by',
            'AO1' => 'fclerk_name',
            'AP1' => 'fcancel_memo',
            'AQ1' => 'fcancel_name',
        ];
        
        // Apply headers
        foreach ($headers as $cell => $header) {
            $sheet->setCellValue($cell, $header);
        }

        // Initialize row counter
        $row = 2; // Start from the second row since first row is for headers

        // Loop through each record
        foreach ($sales_trans_array as $sales_transaction) {
            foreach ($sales_transaction->record as $record) {
               $saleDate = $record->fsale_date;
               $saleTime = $record->fsale_time;
               $fzCounter = $record->fzcounter;
               $terminald = $record->ftermid;
               $documentNo = $record->fdocument_no;
               $accountld = $record->faccountid;
               $accountName = $record->faccount_name;
               $tpAccountld = $record->fthirdparty_accountid;
               $fsiteid = $record->fsiteid;
               $fofficeid = $record->fofficeid;
               $ftotal_discount = $record->ftotal_discount;
               $fline_discount = $record->fline_discount;
               $fscdiscount = $record->fscdiscount;
               $fpwd_discount = $record->fpwd_discount;
               $fdip_discount = $record->fdip_discount;
               $fgross = $record->fgross;
               $flocal_tax = $record->flocal_tax;
               $famusement_tax = $record->famusement_tax;
               $frefund = $record->frefund;
               $fservice_charge = $record->fservice_charge;
               $fsubtotal = $record->fsubtotal;
               $ftax = $record->ftax;
               $ftax_sale = $record->ftax_sale;
               $fnotax_sale = $record->fnotax_sale;
               $fzero_rated_sale = $record->fzero_rated_sale;
               $fcash = $record->fcash;
               $fcharge = $record->fcharge;
               $fcredit = $record->fcredit;
               $fcheck = $record->fcheck;
               $fothers = $record->fothers;
               $fevat = $record->fevat;
               $fvat_exempt = $record->fvat_exempt;
               $fewt = $record->fewt;
               $fcustomer_count = $record->fcustomer_count;
               $fcashier_name = $record->fcashier_name;
               $fcashierid = $record->fcashierid;
               $fposted_date = $record->fposted_date;
               $fupdated_date = $record->fupdated_date;
               $fcreated_date = $record->fcreated_date;
               $fserviced_by = $record->fserviced_by;
               $fclerk_name = $record->fclerk_name;
               $fcancel_memo = $record->fcancel_memo;
               $fcancel_name = $record->fcancel_name;

               // Insert data into the Excel sheet
               $sheet->setCellValue('A' . $row, $saleDate);
               $sheet->setCellValue('B' . $row, $saleTime);
               $sheet->setCellValue('C' . $row, $fzCounter);
               $sheet->setCellValue('D' . $row, $terminald);
               $sheet->setCellValue('E' . $row, $documentNo);
               $sheet->setCellValue('F' . $row, $accountld);
               $sheet->setCellValue('G' . $row, $accountName);
               $sheet->setCellValue('H' . $row, $tpAccountld);
               $sheet->setCellValue('I' . $row, $fsiteid);
               $sheet->setCellValue('J' . $row, $fofficeid);
               $sheet->setCellValue('K' . $row, $ftotal_discount);
               $sheet->setCellValue('L' . $row, $fline_discount);
               $sheet->setCellValue('M' . $row, $fscdiscount);
               $sheet->setCellValue('N' . $row, $fpwd_discount);
               $sheet->setCellValue('O' . $row, $fdip_discount);
               $sheet->setCellValue('P' . $row, $fgross);
               $sheet->setCellValue('Q' . $row, $flocal_tax);
               $sheet->setCellValue('R' . $row, $famusement_tax);
               $sheet->setCellValue('S' . $row, $frefund);
               $sheet->setCellValue('T' . $row, $fservice_charge);
               $sheet->setCellValue('U' . $row, $fsubtotal);
               $sheet->setCellValue('V' . $row, $ftax);
               $sheet->setCellValue('W' . $row, $ftax_sale);
               $sheet->setCellValue('X' . $row, $fnotax_sale);
               $sheet->setCellValue('Y' . $row, $fzero_rated_sale);
               $sheet->setCellValue('Z' . $row, $fcash);
               $sheet->setCellValue('AA' . $row, $fcharge);
               $sheet->setCellValue('AB' . $row, $fcredit);
               $sheet->setCellValue('AC' . $row, $fcheck);
               $sheet->setCellValue('AD' . $row, $fothers);
               $sheet->setCellValue('AE' . $row, $fevat);
               $sheet->setCellValue('AF' . $row, $fvat_exempt);
               $sheet->setCellValue('AG' . $row, $fewt);
               $sheet->setCellValue('AH' . $row, $fcustomer_count);
               $sheet->setCellValue('AI' . $row, $fcashier_name);
               $sheet->setCellValue('AJ' . $row, $fcashierid);
               $sheet->setCellValue('AK' . $row, $fposted_date);
               $sheet->setCellValue('AL' . $row, $fupdated_date);
               $sheet->setCellValue('AM' . $row, $fcreated_date);
               $sheet->setCellValue('AN' . $row, $fserviced_by);
               $sheet->setCellValue('AO' . $row, $fclerk_name);
               $sheet->setCellValue('AP' . $row, $fcancel_memo);
               $sheet->setCellValue('AQ' . $row, $fcancel_name);

               // Move to the next row for the next product/payment
               $row++;
            }
        }

        // foreach($cashier_declaration_array[0] as $pota) {
        //     echo $pota->fcashier_name . " " . "<br>";
        // }
        // die();

        // $sum_of_sales = 0;     
        // foreach ($sales_test_array as $st_wew_record) {
        //     // echo "Fsaledate in SALES: " . $st_wew_record->fsale_date . "<br>";
        //     $test_sales_fsaledate = $st_wew_record->fsale_date;
        //     $test_sales_fcashiername = $st_wew_record->fcashier_name;
        //     $test_sales_termid = $st_wew_record->ftermid;
            
        //     $credithaha = $st_wew_record->fcredit;

        //     foreach($cashier_declaration_array[0] as $pota) {
        //         echo $pota->fsale_date . " ---- " . $test_sales_fsaledate . " ---- " . $credithaha . "<br>";
        //     }
        // }

        // die();

        // SVR Worksheet Start here
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(1);
        $sheet2 = $objPHPExcel->getActiveSheet()->setTitle('Sales Variance Report');

        // Set headers in the Excel sheet
        $headers2 = [
            'A1' => 'DATE',
            'B1' => 'SHIFT',
            'C1' => 'CASHIER(FULLNAME/NICKNAME)',
            'D1' => 'DECLARED CASH',
            'E1' => 'CALCULATED CASH (SALES INVOICE)',
            'F1' => 'NET OF SPECIAL SALES',
            'G1' => 'CASH OVER/SHORT - VARIANCE DECLARED VS CALCULATED',
            'H1' => 'DATE OF TRANSACTION',
            'I1' => 'BANK DEPOSIT',
            'J1' => 'VARIANCE DECLARED VS DEPOSITED',
            'K1' => 'OTHER DEPOSITS(MANUAL SALES)',
            'L1' => 'CREDIT CARD SALES',
            'M1' => 'CREDIT CARD CHARGE',
            'N1' => 'CR MEMO',
            'O1' => 'G.C',
            'P1' => 'PAYMAYA',
            'Q1' => 'VIP SOLD',
            'R1' => 'VIP',
            'S1' => 'CENTURY SHOPAHOLIC VOUCHERS',
            'T1' => 'GCASH',
            'U1' => 'FOOD PANDA A/R',
            'V1' => 'HONESTBEE',
            'W1' => 'METRODEAL (NET SALE)',
            'X1' => 'MARKETING A/R',
            'Y1' => 'OTHER SM EVENTS',
            'Z1' => 'LAZADA',
            'AA1' => 'SHOPEE',
            'AB1' => 'GRAB',
            'AC1' => 'BOOKY',
            'AD1' => 'POODTRIP',
            'AE1' => 'PICK.A.ROO',
            'AF1' => 'PARAHERO',
            'AG1' => 'RARE FOOD SHOP',
            'AH1' => 'SHOPEEPAY',
            'AI1' => 'METROMART',
            'AJ1' => 'ZALORA',
            'AK1' => 'EATIGO',
            'AL1' => 'MADISON',
            'AM1' => 'SM ONLINE',
            'AN1' => 'TOTAL NON-CASH',
            'AO1' => '',
            'AP1' => 'TOTAL PAYMENTS',
            'AQ1' => 'BULK / WHOLESALE/IN HOUSE',
            'AR1' => 'OTHERS (Please Specify)',
            'AS1' => 'CATERING',
            'AT1' => 'OFFSITE SELLING',
            'AU1' => 'RESELLER',
            'AV1' => 'SNACKSHOP',
            'AW1' => 'DELIVERY FEE',
            'AX1' => 'CART SALES',
            'AY1' => 'CONSIGNMENT',
            'AZ1' => 'TOTAL SPECIAL SALES',
            'BA1' => 'OVERALL SALES',
            'BB1' => 'SR. CITIZEN DISC',
            'BC1' => 'PWD DISC',
            'BD1' => 'OTHER DISC',
            'BE1' => 'TRANSACTION COUNT (POS)',
            'BF1' => 'GC ORIGINATING STORE',
            'BG1' => 'GC SERIAL NUMBER',
            'BH1' => 'TERMINALID',
            'BI1' => 'VOIDS',
        ];

        // Set headers in the second sheet
        foreach ($headers2 as $cell2 => $header2) {
            $sheet2->setCellValue($cell2, $header2);
        }

        foreach (range('A', 'Z') as $columnID) {
            $sheet2->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet2->getColumnDimension('AA')->setAutoSize(true);
        $sheet2->getColumnDimension('AB')->setAutoSize(true);
        $sheet2->getColumnDimension('AC')->setAutoSize(true);
        $sheet2->getColumnDimension('AD')->setAutoSize(true);
        $sheet2->getColumnDimension('AE')->setAutoSize(true);
        $sheet2->getColumnDimension('AF')->setAutoSize(true);
        $sheet2->getColumnDimension('AG')->setAutoSize(true);
        $sheet2->getColumnDimension('AH')->setAutoSize(true);
        $sheet2->getColumnDimension('AI')->setAutoSize(true);
        $sheet2->getColumnDimension('AJ')->setAutoSize(true);
        $sheet2->getColumnDimension('AK')->setAutoSize(true);
        $sheet2->getColumnDimension('AL')->setAutoSize(true);
        $sheet2->getColumnDimension('AM')->setAutoSize(true);
        $sheet2->getColumnDimension('AN')->setAutoSize(true);
        $sheet2->getColumnDimension('AO')->setwidth(20);
        $sheet2->getColumnDimension('AP')->setAutoSize(true);
        $sheet2->getColumnDimension('AQ')->setAutoSize(true);
        $sheet2->getColumnDimension('AR')->setAutoSize(true);
        $sheet2->getColumnDimension('AS')->setAutoSize(true);
        $sheet2->getColumnDimension('AT')->setAutoSize(true);
        $sheet2->getColumnDimension('AU')->setAutoSize(true);
        $sheet2->getColumnDimension('AV')->setAutoSize(true);
        $sheet2->getColumnDimension('AW')->setAutoSize(true);
        $sheet2->getColumnDimension('AX')->setAutoSize(true);
        $sheet2->getColumnDimension('AY')->setAutoSize(true);
        $sheet2->getColumnDimension('AZ')->setAutoSize(true);
        $sheet2->getColumnDimension('BA')->setAutoSize(true);
        $sheet2->getColumnDimension('BB')->setAutoSize(true);
        $sheet2->getColumnDimension('BC')->setAutoSize(true);
        $sheet2->getColumnDimension('BD')->setAutoSize(true);
        $sheet2->getColumnDimension('BE')->setAutoSize(true);
        $sheet2->getColumnDimension('BF')->setAutoSize(true);
        $sheet2->getColumnDimension('BG')->setAutoSize(true);
        $sheet2->getColumnDimension('BH')->setAutoSize(true);
        $sheet2->getColumnDimension('BI')->setAutoSize(true);

        $sheet2->getStyle('A1:C1')->applyFromArray([
            'fill' => [
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => ['rgb' => '3333FF'],
            ],
        ]);

        $sheet2->getStyle('D1:L1')->applyFromArray([
            'fill' => [
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'],
            ],
        ]);

        $sheet2->getStyle('D1:K1')->applyFromArray([
            'fill' => [
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'],
            ],
        ]);

        $sheet2->getStyle('L1:AO1')->applyFromArray([
            'fill' => [
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => ['rgb' => 'FF33FF'],
            ],
        ]);

        $sheet2->getStyle('AP1')->applyFromArray([
            'fill' => [
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => ['rgb' => '00FFFF'],
            ],
        ]);

        $sheet2->getStyle('AQ1:AZ1')->applyFromArray([
            'fill' => [
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => ['rgb' => 'FF3333'],
            ],
        ]);

        $sheet2->getStyle('BA1:BD1')->applyFromArray([
            'fill' => [
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => ['rgb' => 'FF33FF'],
            ],
        ]);

        $sheet2->getStyle('BE1:BI1')->applyFromArray([
            'fill' => [
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => ['rgb' => '009900'],
            ],
        ]);

        // Initialize row counter
        $row2 = 2; // Start from the second row since first row is for headers

        // Loop through each record
        foreach ($cashier_declaration_array[0] as $cashier_record) {
            $date_from_cashier_declaration = DateTime::createFromFormat('Ymd', $cashier_record->fsale_date);
            $cashier_saleDate = $date_from_cashier_declaration->format('d/m/Y');

            $cashier_fullName = $cashier_record->fcashier_name;
            $cashier_declaredCash = $cashier_record->fcash_declare;
            $cashier_calculatedCash = $cashier_record->fcash;
            $cashier_cashOver = $cashier_record->fother_diff;


            // To get sum of credit card sales
            $this->db->select('*')
                      ->from('parent_tb')
                      ->where('fsale_date', $cashier_record->fsale_date)
                      ->where('fcashier_name', $cashier_record->fcashier_name)
                      ->where('ftermid', $cashier_record->ftermid)
                      ->group_by('fdocument_no');

            $query_for_cc_sales = $this->db->get();
            $cc_sales_result = $query_for_cc_sales->result();

            $cashier_credit_card_sales = 0;
            foreach ($cc_sales_result as $row_cc_sales) {
                $cashier_credit_card_sales += $row_cc_sales->fcredit;
            }

            // $query = $this->db->get();
            // $this->db->select_sum('fcredit');
            // $this->db->where('fsale_date', $cashier_record->fsale_date);
            // $this->db->where('fcashier_name', $cashier_record->fcashier_name);
            // $this->db->where('ftermid', $cashier_record->ftermid);
            // $query_for_cc_sales = $this->db->get('parent_tb');

            // $cc_sales_result = $query_for_cc_sales->row();
            // $cashier_credit_card_sales = $cc_sales_result->fcredit;
            // End

            // To get sum of paymaya
            $this->db->select_sum('famount');
            $this->db->where('fsale_date', $cashier_record->fsale_date);
            $this->db->where('fcashier_name', $cashier_record->fcashier_name);
            $this->db->where('ftermid', $cashier_record->ftermid);
            $this->db->where('finfo2', '107');
            $query_for_paymaya = $this->db->get('parent_tb');

            $paymaya_result = $query_for_paymaya->row();
            $cashier_paymaya = $paymaya_result->famount;
            // End

            // To get sum of GCASH
            $this->db->select_sum('famount');
            $this->db->where('fsale_date', $cashier_record->fsale_date);
            $this->db->where('fcashier_name', $cashier_record->fcashier_name);
            $this->db->where('ftermid', $cashier_record->ftermid);
            $this->db->where('finfo2', '106');
            $query_for_gcash = $this->db->get('parent_tb');

            $gcash_result = $query_for_gcash->row();
            $cashier_gcash = $gcash_result->famount;
            // End

            // To get sum of Food Panda
            $this->db->select_sum('famount');
            $this->db->where('fsale_date', $cashier_record->fsale_date);
            $this->db->where('fcashier_name', $cashier_record->fcashier_name);
            $this->db->where('ftermid', $cashier_record->ftermid);
            $this->db->where('finfo2', '103');
            $query_for_foodpanda = $this->db->get('parent_tb');

            $foodpanda_result = $query_for_foodpanda->row();
            $cashier_foodpanda = $foodpanda_result->famount;
            // End

            // To get sum of Marketing AR
            $this->db->select_sum('famount');
            $this->db->where('fsale_date', $cashier_record->fsale_date);
            $this->db->where('fcashier_name', $cashier_record->fcashier_name);
            $this->db->where('ftermid', $cashier_record->ftermid);
            $this->db->where('finfo2', '126');
            $query_for_marketing = $this->db->get('parent_tb');

            $marketing_result = $query_for_marketing->row();
            $cashier_marketing = $marketing_result->famount;
            // End

            // To get sum of LAZADA
            $this->db->select_sum('famount');
            $this->db->where('fsale_date', $cashier_record->fsale_date);
            $this->db->where('fcashier_name', $cashier_record->fcashier_name);
            $this->db->where('ftermid', $cashier_record->ftermid);
            $this->db->where('finfo2', '111');
            $query_for_lazada = $this->db->get('parent_tb');

            $lazada_result = $query_for_lazada->row();
            $cashier_lazada = $lazada_result->famount;
            // End

            // To get sum of Shopee
            $this->db->select_sum('famount');
            $this->db->where('fsale_date', $cashier_record->fsale_date);
            $this->db->where('fcashier_name', $cashier_record->fcashier_name);
            $this->db->where('ftermid', $cashier_record->ftermid);
            $this->db->where('finfo2', '124');
            $query_for_shopee = $this->db->get('parent_tb');

            $shopee_result = $query_for_shopee->row();
            $cashier_shopee = $shopee_result->famount;
            // End

            // To get sum of GRAB
            $this->db->select_sum('famount');
            $this->db->where('fsale_date', $cashier_record->fsale_date);
            $this->db->where('fcashier_name', $cashier_record->fcashier_name);
            $this->db->where('ftermid', $cashier_record->ftermid);
            $this->db->where('finfo2', '112');
            $query_for_grab = $this->db->get('parent_tb');

            $grab_result = $query_for_grab->row();
            $cashier_grab = $grab_result->famount;
            // End

            // To get sum of POODTRIP
            $this->db->select_sum('famount');
            $this->db->where('fsale_date', $cashier_record->fsale_date);
            $this->db->where('fcashier_name', $cashier_record->fcashier_name);
            $this->db->where('ftermid', $cashier_record->ftermid);
            $this->db->where('finfo2', '115');
            $query_for_poodtrip = $this->db->get('parent_tb');

            $poodtrip_result = $query_for_poodtrip->row();
            $cashier_poodtrip = $poodtrip_result->famount;
            // End

            // To get sum of PICK.A.ROO
            $this->db->select_sum('famount');
            $this->db->where('fsale_date', $cashier_record->fsale_date);
            $this->db->where('fcashier_name', $cashier_record->fcashier_name);
            $this->db->where('ftermid', $cashier_record->ftermid);
            $this->db->where('finfo2', '117');
            $query_for_pickaroo = $this->db->get('parent_tb');

            $pickaroo_result = $query_for_pickaroo->row();
            $cashier_pickaroo = $pickaroo_result->famount;
            // End

            // To get sum of PARAHERO
            $this->db->select_sum('famount');
            $this->db->where('fsale_date', $cashier_record->fsale_date);
            $this->db->where('fcashier_name', $cashier_record->fcashier_name);
            $this->db->where('ftermid', $cashier_record->ftermid);
            $this->db->where('finfo2', '118');
            $query_for_parahero = $this->db->get('parent_tb');

            $parahero_result = $query_for_parahero->row();
            $cashier_parahero = $parahero_result->famount;
            // End

            // To get sum of RARE FOOD SHOP
            $this->db->select_sum('famount');
            $this->db->where('fsale_date', $cashier_record->fsale_date);
            $this->db->where('fcashier_name', $cashier_record->fcashier_name);
            $this->db->where('ftermid', $cashier_record->ftermid);
            $this->db->where('finfo2', '121');
            $query_for_rarefoodshop = $this->db->get('parent_tb');

            $rarefoodshop_result = $query_for_rarefoodshop->row();
            $cashier_rarefoodshop = $rarefoodshop_result->famount;
            // End

            // To get sum of Metromart
            $this->db->select_sum('famount');
            $this->db->where('fsale_date', $cashier_record->fsale_date);
            $this->db->where('fcashier_name', $cashier_record->fcashier_name);
            $this->db->where('ftermid', $cashier_record->ftermid);
            $this->db->where('finfo2', '127');
            $query_for_metromart = $this->db->get('parent_tb');

            $metromart_result = $query_for_metromart->row();
            $cashier_metromart = $metromart_result->famount;
            // End

            // To get sum of ZALORA
            $this->db->select_sum('famount');
            $this->db->where('fsale_date', $cashier_record->fsale_date);
            $this->db->where('fcashier_name', $cashier_record->fcashier_name);
            $this->db->where('ftermid', $cashier_record->ftermid);
            $this->db->where('finfo2', '125');
            $query_for_zalora = $this->db->get('parent_tb');

            $zalora_result = $query_for_zalora->row();
            $cashier_zalora = $zalora_result->famount;
            // End

            // To get sum of EATIGO
            $this->db->select_sum('famount');
            $this->db->where('fsale_date', $cashier_record->fsale_date);
            $this->db->where('fcashier_name', $cashier_record->fcashier_name);
            $this->db->where('ftermid', $cashier_record->ftermid);
            $this->db->where('finfo2', '128');
            $query_for_eatigo = $this->db->get('parent_tb');

            $eatigo_result = $query_for_eatigo->row();
            $cashier_eatigo = $eatigo_result->famount;
            // End

            // To get sum of SM Online
            $this->db->select_sum('famount');
            $this->db->where('fsale_date', $cashier_record->fsale_date);
            $this->db->where('fcashier_name', $cashier_record->fcashier_name);
            $this->db->where('ftermid', $cashier_record->ftermid);
            $this->db->where('finfo2', '130');
            $query_for_sm = $this->db->get('parent_tb');

            $sm_result = $query_for_sm->row();
            $cashier_sm = $sm_result->famount;
            // End

            // To get sum of Senior Citizen Discount
            $this->db->select_sum('fscdiscount');
            $this->db->where('fsale_date', $cashier_record->fsale_date);
            $this->db->where('fcashier_name', $cashier_record->fcashier_name);
            $this->db->where('ftermid', $cashier_record->ftermid);
            $query_for_senior = $this->db->get('parent_tb');

            $senior_result = $query_for_senior->row();
            $cashier_senior = $senior_result->fscdiscount;
            // End

            // To get sum of PWD Discount
            $this->db->select_sum('fpwd_discount');
            $this->db->where('fsale_date', $cashier_record->fsale_date);
            $this->db->where('fcashier_name', $cashier_record->fcashier_name);
            $this->db->where('ftermid', $cashier_record->ftermid);
            $query_for_pwd = $this->db->get('parent_tb');

            $pwd_result = $query_for_pwd->row();
            $cashier_pwd = $pwd_result->fpwd_discount;
            // End

            // To get sum of Other Discount
            $this->db->select_sum('ftotal_discount');
            $this->db->where('fsale_date', $cashier_record->fsale_date);
            $this->db->where('fcashier_name', $cashier_record->fcashier_name);
            $this->db->where('ftermid', $cashier_record->ftermid);
            $query_for_otherdisc = $this->db->get('parent_tb');

            $otherdisc_result = $query_for_otherdisc->row();
            $cashier_otherdisc = $otherdisc_result->ftotal_discount;
            // End

            // To get Transaction Count
            $this->db->select('*')
                      ->from('parent_tb')
                      ->where('fsale_date', $cashier_record->fsale_date)
                      ->where('fcashier_name', $cashier_record->fcashier_name)
                      ->where('ftermid', $cashier_record->ftermid)
                      ->group_by('fdocument_no');

            $transaction_count = $this->db->count_all_results();
            // End

            $terminal_id = $cashier_record->ftermid;

            // Insert data into the Excel sheet
            $sheet2->setCellValue('A' . $row2, $cashier_saleDate);
            $sheet2->setCellValue('B' . $row2, '');
            $sheet2->setCellValue('C' . $row2, $cashier_fullName);
            $sheet2->setCellValue('D' . $row2, $cashier_declaredCash);
            $sheet2->setCellValue('E' . $row2, $cashier_calculatedCash);
            $sheet2->setCellValue('F' . $row2, '');
            $sheet2->setCellValue('G' . $row2, $cashier_cashOver);
            $sheet2->setCellValue('H' . $row2, '');
            $sheet2->setCellValue('I' . $row2, '');
            $sheet2->setCellValue('J' . $row2, '');
            $sheet2->setCellValue('K' . $row2, '');
            $sheet2->setCellValue('L' . $row2, $cashier_credit_card_sales);
            $sheet2->setCellValue('M' . $row2, '');
            $sheet2->setCellValue('N' . $row2, '');
            $sheet2->setCellValue('O' . $row2, '');
            $sheet2->setCellValue('P' . $row2, $cashier_paymaya);
            $sheet2->setCellValue('Q' . $row2, '');
            $sheet2->setCellValue('R' . $row2, '');
            $sheet2->setCellValue('S' . $row2, '');
            $sheet2->setCellValue('T' . $row2, $cashier_gcash);
            $sheet2->setCellValue('U' . $row2, $cashier_foodpanda);
            $sheet2->setCellValue('V' . $row2, '');
            $sheet2->setCellValue('W' . $row2, '');
            $sheet2->setCellValue('X' . $row2, $cashier_marketing);
            $sheet2->setCellValue('Y' . $row2, '');
            $sheet2->setCellValue('Z' . $row2, $cashier_lazada);
            $sheet2->setCellValue('AA' . $row2, $cashier_shopee);
            $sheet2->setCellValue('AB' . $row2, $cashier_grab);
            $sheet2->setCellValue('AC' . $row2, '');
            $sheet2->setCellValue('AD' . $row2, $cashier_poodtrip);
            $sheet2->setCellValue('AE' . $row2, $cashier_pickaroo);
            $sheet2->setCellValue('AF' . $row2, $cashier_parahero);
            $sheet2->setCellValue('AG' . $row2, $cashier_rarefoodshop);
            $sheet2->setCellValue('AH' . $row2, '');
            $sheet2->setCellValue('AI' . $row2, $cashier_metromart);
            $sheet2->setCellValue('AJ' . $row2, $cashier_zalora);
            $sheet2->setCellValue('AK' . $row2, $cashier_eatigo);
            $sheet2->setCellValue('AL' . $row2, '');
            $sheet2->setCellValue('AM' . $row2, $cashier_sm);
            $sheet2->setCellValue('AN' . $row2, "=SUM(L{$row2}:AM{$row2})");
            $sheet2->setCellValue('AO' . $row2, '');
            $sheet2->setCellValue('AP' . $row2, "=AN{$row2}+E{$row2}");
            $sheet2->setCellValue('AQ' . $row2, '');
            $sheet2->setCellValue('AR' . $row2, '');
            $sheet2->setCellValue('AS' . $row2, '');
            $sheet2->setCellValue('AT' . $row2, '');
            $sheet2->setCellValue('AU' . $row2, '');
            $sheet2->setCellValue('AV' . $row2, '');
            $sheet2->setCellValue('AW' . $row2, '');
            $sheet2->setCellValue('AX' . $row2, '');
            $sheet2->setCellValue('AY' . $row2, '');
            $sheet2->setCellValue('AZ' . $row2, '');
            $sheet2->setCellValue('BA' . $row2, '');
            $sheet2->setCellValue('BB' . $row2, $cashier_senior);
            $sheet2->setCellValue('BC' . $row2, $cashier_pwd);
            $sheet2->setCellValue('BD' . $row2, $cashier_otherdisc);
            $sheet2->setCellValue('BE' . $row2, $transaction_count);
            $sheet2->setCellValue('BF' . $row2, '');
            $sheet2->setCellValue('BG' . $row2, '');
            $sheet2->setCellValue('BH' . $row2, $terminal_id);
            $sheet2->setCellValue('BI' . $row2, '');
            
            $row2++;
        }

        // Set the first sheet as active before saving
        $objPHPExcel->setActiveSheetIndex(1);

        // Set headers for the output Excel file
        $filenameDate = date("F j, Y", strtotime($this->input->post('fromDate'))) . " - " . date("F j, Y", strtotime($this->input->post('toDate')));
        $filename = "Sales Variance Report as of " . $filenameDate . ".xlsx";
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        // Write the file
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');

        $this->db->truncate('parent_tb');
    }
}