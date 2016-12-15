<?php
/* This file will import the csv file what we created with the eportcmsblocks.php file */
require_once('../app/Mage.php');
Mage::app('admin');
$file = "cmsblock.csv";

if ($file == null):
    echo "No file exiting now.";
    die;
endif;

Mage::app()->getStore()->setId(Mage_Core_Model_App::ADMIN_STORE_ID);
Mage::register("isSecureArea", true);

$mage_csv = new Varien_File_Csv();
$csvdata = $mage_csv->getData($file);

$coreResource = Mage::getSingleton('core/resource');
$connect = $coreResource->getConnection('core_write');

/*
 * CMS Block Import
 * */

$cmsblock=Mage::getModel('cms/block');
foreach ($csvdata as $data) :
    try {
        $block=$cmsblock->load($data[0]);

        $block->setData('title',$data[1]);
        $block->setData('content',$data[2]);

        $block->save();
        echo $data[0]. ' was updated.'.PHP_EOL;
    } catch (Exception $e) {
        echo " Error on updating the CMS blocks: ".$e->getMessage().PHP_EOL;
    }

endforeach;

/*
 *
 *
 *  CMS pages */
$file = "cmspage.csv";
$mage_csv = new Varien_File_Csv();
$csvdata = $mage_csv->getData($file);

$cmsblock=Mage::getModel('cms/page');
foreach ($csvdata as $data) :
    try {
        $page=$cmsblock->load($data[0]);

        $block->setData('title',$data[1]);
        $block->setData('content',$data[2]);

        $block->save();
        echo $data[0]. ' was updated.'.PHP_EOL;
    } catch (Exception $e) {
        echo " Error on updateing the CMS page: ".$e->getMessage().PHP_EOL;
    }

endforeach;

echo "FINISHED.". PHP_EOL;