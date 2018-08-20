<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use PHPExcel_IOFactory;

/**
 * This is the form class for Finance.
 *
 * @property string $import_file 导入文件
 */
class FinanceForm extends Model
{
    public $import_file;

    /**
     * 字段过滤
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * 字段的显示
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'import_file' => Yii::t('app', '导入文件'),
        ];
    }

    /**
     * 上传文件
     */
    public function upload_file($file_name, $save_dir, $save_name, $file_type = ['jpg', 'txt', 'xls', 'xlsx', 'jpeg', 'png'])
    {
        $dir = Yii::$app->basePath . '/' . $save_dir;
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $file = UploadedFile::getInstanceByName($file_name);
        $absolute_path = $dir . $save_name . '.' . $file->extension;
        $relative_path = $save_dir . $save_name . '.' . $file->extension;
        if (in_array($file->extension, $file_type)) {
            if ($file && $file->saveAs($absolute_path)) {
                $data['absolute_path'] = $absolute_path;
                $data['relative_path'] = $relative_path;
                return $data;
            } else {
                return '上传失败';
            }
        } else {
            return '格式不对!请选择正确文件';
        }
    }

    //批量导入
    public function orgusermanager_import($path)
    {
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        switch ($extension) {
            case 'xlsx':
                $excelReader = PHPExcel_IOFactory::createReader('Excel2007');
                break;
            case 'xls':
                $excelReader = PHPExcel_IOFactory::createReader('Excel5');
                break;
            case 'csv':
                $excelReader = PHPExcel_IOFactory::createReader('CSV');
                break;
        }

        $phpexcel = $excelReader->load($path)->getSheet(0);  //载入文件并获取第一个sheet
        $total_line = $phpexcel->getHighestRow();            //多少行
        $total_column = $phpexcel->getHighestColumn();       //多少列
        $err = array();
        for ($row = 1; $row <= $total_line; $row++) {
            $oneUser = array();
            for ($column = 'A'; $column <= $total_column; $column++) {
                $value = trim($phpexcel->getCell($column . $row)->getValue());
                $oneUser[] = $value;
                var_dump($value, $total_column);
            }
            die;
            var_dump($oneUser);//获取到的每一行数据
            // $transaction = Yii::$app->db->beginTransaction();
            // $usermodel = new ProjectAdviser();
            // try {
            //     //user表添加用户
            //     $usermodel->username = $oneUser[0];
            //     $usermodel->password = $oneUser[1];
            //     $usermodel->email = $oneUser[2];
            //     $usermodel->is_bind = 1;
            //     if (!$usermodel->save()) {
            //         throw new Exception('user表保存失败');
            //     };
            //     $transaction->commit();
            // } catch (Exception $e) {
            //     $transaction->rollBack();
            //     $err = $e->getMessage();
            //     break;
            // }
            //若不存在,就判断是否达到绑定上限
        }
        die;
        return ($err);
    }
}
