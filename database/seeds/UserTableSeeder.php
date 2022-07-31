<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Model;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //1: Admin
        // $mail_admin = ['quynhlien', 'quynhanh', 'quangtay', 'hoangphuc', 'admin5'];
        // $name_admin = ['Quỳnh Liên', 'Quỳnh Anh', 'Lê Quang Tây', 'Bùi Hoàng Phúc', 'admin5'];
        // for($i = 0; $i < 5; $i++){
        //     Model\MUser::create([
        //         'mail' => $mail_admin[$i],
        //         'name' => $name_admin[$i],
        //         'password' => Hash::make('123456'),
        //         'role' => 1,
        //         'test_id' => 'General OS '.$i,
        //         'code' => 'General OS '.$i
        //     ]);
        // }

        //2: Teacher
        $mail_teacher = ['quynhlien@mail.com', 'quynhanh@mail.com', 'quangtay@mail.com', 'hoangphuc@mail.com', 'teacher@mail.com'];
        $name_teacher = ['Quỳnh Liên', 'Quỳnh Anh', 'Lê Quang Tây', 'Bùi Hoàng Phúc', 'teacher'];
        for($i = 0; $i < 5; $i++){
            Model\MUser::create([
                'mail' => $mail_teacher[$i],
                'name' => $name_teacher[$i],
                'password' => Hash::make('123456'),
                'role' => 2
            ]);
        }

        //3: Student
        $mail_student = ['hoangkhang@mail.com', 'minhthuan@mail.com', 'huuduy@mail.com', 'macly@mail.com', 'daihiep@mail.com', 'ngocnam@mail.com', 'vantai@mail.com'];
        $name_student = ['Nguyễn Hoàng Khang', 'Nguyễn Huỳnh Minh Thuận', 'Trần Hữu Duy', 'Thạch Mạc Ly', 'La Đại Hiệp', 'Phạm Ngọc Nam', 'Nguyễn Văn Tài'];
        for($i = 0; $i < 7; $i++){
            Model\MUser::create([
                'mail' => $mail_student[$i],
                'name' => $name_student[$i],
                'password' => Hash::make('123456'),
                'role' => 2, //'role' => 3,
                'test_id' => $i+1
            ]);
        }
    }
}
