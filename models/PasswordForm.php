<?php
    namespace app\models;
   
    use Yii;
    use yii\base\Model;
    use app\models\User;
   
    class PasswordForm extends Model{
        public $oldpass;
        public $newpass;
        public $repeatnewpass;
       
        public function rules(){
            return [
                [['oldpass','newpass','repeatnewpass'],'required'],
                ['oldpass','findPasswords'],
                ['repeatnewpass','compare','compareAttribute'=>'newpass'],
            ];
        }
       
        public function findPasswords($attribute, $params){
    
            $user = User::find()->where([
                'username'=>Yii::$app->user->identity->username
            ])->one();
            $password = $user->password_hash;
            if(Yii::$app->security->validatePassword($this->oldpass, $password) == NULL)
                $this->addError($attribute, Yii::t('app','Old password is incorrect'));
        }
       
        public function attributeLabels(){
            return [
                'oldpass'=> Yii::t('app','old password'),
                'newpass'=>Yii::t('app','new password'),
                'repeatnewpass'=>Yii::t('app','Repeat New Password'),
            ];
        }
    } 