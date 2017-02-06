<?php


class intructor_view
{
    public function __construct()
    {
    }

    public function contentComplete()
    {
        echo 'สร้างเนื้อหาสำเร็จ';
    }

    public function contentFail()
    {
        echo 'เกิดปัญหาในการสร้าง';
    }
    public function examinationComplete()
    {
        echo 'สร้างโจทย์สำเร็จ';
    }
    public function examinationFail()
    {
        echo 'เกิดปัญหาในการสร้างโจทย์';
    }
}
