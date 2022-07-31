<?php

use Illuminate\Database\Seeder;
use App\Model;

class QuestionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Cau 1
        $content1 = [];
        $content1[1] = [
            'A: 日本は　はじめてですか。<br>
            B: いや、３回目です。<br>',
            'A: え～どれ？これ？<br>
            B: うん、それ。<br>',
            'A: 日本に来て、どのぐらいですか？<br>
            B: ３年８ヶ月です。<br>',
            'A: 黄色と赤の花をください。 <br>
            B: ……………………<br>(Give me your answer!)<br>',
            'A: ゆかちゃん、じゃーね。 <br>
            B: ……………………<br>(Give me your answer!)<br>',
            'A:　ごちそうさまでした。とってもおいしかったです。 <br>
            B: ……………………<br>(Give me your answer!)<br>',
            'A: Thưa…tôi xin phép về trước ạ! <br>
            B: Ơ, về à? Sau đây chúng tôi định đi uống đấy… <br>
            A: Tôi xin phép được từ chối ạ! <br>',
            'A: Nè nè nè! Dự định ngày mai của ông là gì?<br>
            B: Hỏi để làm gì? Khó chịu quá đấy!<br>',
        ];

        $content1[2] = [
            'A: この店、どうだった？<br>
            B: う～ん、料理はおいしいけど、サービスがちょっとね。。。<br>',
            'A: うわ、おいしそう！それ何ですか？<br>
            B: これ？中国のお菓子。一つどう？<br>',
            'A: この辺に、駅、ありますか？<br>
            B: ええ、すぐそこです。<br>',
            'A: あれ？山田さん、どこ行くの？<br>
            B: ……………………<br>(Give me your answer!)<br>',
            'A: 今年は何年？<br>
            B: ……………………<br>(Give me your answer!)<br>',
            'A: あのー、会社の電話番号は分かりますか？<br>
            B: ……………………<br>(Give me your answer!)<br>',
            'A: Tuần sau, tôi đi Nhật ạ!<br>
            B: Chuyện đó thật mong chờ nhỉ!<br>',
            'A: Sau đây tôi định đi uống đấy…<br>
            B: Ô hay nhỉ! Vậy cùng đi nào!<br>',
        ];

        $content1[3] = [
            'A: ね、サラさんは字がきれいですね！<br>
            B: どれ？見せて！うわ、本当だ！<br>',
            'A: 今日はすずしいね～！<br>
            B: ええ、本当に！<br>',
            'A: あ、おなかいっぱい！<br>
            B: うん、ぼくも！<br>',
            'A: 豚肉はちょっと…<br>
            B: ……………………<br>(Give me your answer!)<br>',
            'A: この店、サービスもいいし、料理もいいし…<br>
            B: ……………………<br>(Give me your answer!)<br>',
            'A: 日本語の授業はどうですか？<br>
            B: ……………………<br>(Give me your answer!)<br>',
            'A: Ngày mai, mong chờ quá đi..!<br>
            B: Cực kỳ mong chờ luôn nhỉ..!<br>',
            'A: Hôm nay anh chị đã vất vả rồi! Dự định ngày mai thế nào?<br>
            B: Vâng, ngày mai buổi chiều em có tiệc sinh nhật ạ!<br>',
        ];

        $content1[4] = [
            'A: デザート食べましょうか？<br>
            B: ……………………<br>(Give me your answer!)<br>',
            'A: あ～あ！今日は暑いですねー<br>
            B: ……………………<br>(Give me your answer!)<br>',
            'A: 何歳ですか？<br>
            B: ……………………<br>(Give me your answer!)<br>',
            'A: うわ、そのくつ、かわいいね～。<br>
            B: 本当？ありがとう！<br>',
            'A: 山田さん、趣味は何？<br>
            B: 趣味？うーん、写真かな！<br>',
            'A: これは何ですか？<br>
            B: これ？あー、これ、お好み焼き<br>
            A: え？お好み…？<br>
            B: お好み焼き。おいしいよ！<br>',
            'A: Hôm nay, bầu không khí khác quá nhỉ!<br>
            B: Uhm, Vì có buổi hẹn hò cơ mà. Thật sự mong đợi!<br>'
        ];

        $content1[5] = [
            'A: 日本語の勉強はどうですか？<br>
            B: ……………………<br>(Give me your answer!)<br>',
            'A: ビデオレンタルはいくらですか？<br>
            B: ……………………<br>(Give me your answer!)<br>',
            'A: これ、おいしいよ。ちょっと食べてみる？<br>
            B: ……………………<br>(Give me your answer!)<br>',
            'A: あ～あ！<br>
            B: ……………………<br>(Give me your answer!)<br>',
            'A: この写真、みて！ハワイの写真だよ<br>
            B: わー、めっちゃきれいだね！<br>',
            'A: ジョンさん、今日、どこで昼ご飯を食べますか？<br>
            B: ごめーん、もう食べちゃった！<br>',
            'A: あのー、すみません。次の電車は何時に来ましたか？<br>
            B: あ、今の電車は終電です。<br>
            A: 終電？<br>
            B: ええ。電車は明日の朝まで来ません。　<br>',
        ];

        $content1[6] = [
            'A: ごちそさまでした。とってもおいしかったです。<br>
            B: ……………………<br>(Give me your answer!)<br>',
            'A: あれ？鈴木(すずき)さん、どこいくの？<br>
            B: ……………………<br>(Give me your answer!)<br>',
            'A: 和食は大丈夫ですか？<br>
            B: ……………………<br>(Give me your answer!)<br>',
            'A: ノート、３冊ください！<br>
            B: ……………………<br>(Give me your answer!)<br>',
            'A: 山田さんの部屋はきれいですか？<br>
            B:  いえ、きれいじゃありません。でも、家賃(やちん)が安いです。それに、新しいです。<br>',
            'A: この写真、みて！ニャチャンの写真だよ<br>
            B: わー、めっちゃきれいだね！<br>',
            'A: ねねね！サラさんはガールフレンドがいますよ！<br>
            B: 本当？どんな人？<br>
            A: 優(やさ)しい人だよ！それからピアノもひけますよ！<br>
            B: いいね！うらやましい！　<br>',
        ];

        $content1[7] = [
            'A: はじめまして！私は加藤(かとう)です。<br>
            B: ……………………<br>(Give me your answer!)<br>',
            'A: そろそろ失礼します！<br>
            B: ……………………<br>(Give me your answer!)<br>',
            'A: 日本はー、はじめてですか？<br>
            B: ……………………<br>(Give me your answer!)<br>',
            'A: 今年は何年？<br>
            B: ……………………<br>(Give me your answer!)<br>',
            'A: この服、ちょっと小さいです。<br>
            B: じゃー、これはどうですか？<br>',
            'A: 今度の休み、どこいくの？<br>
            B: ボーイフレンドと田舎に帰ります！<br>',
            'A: わ～おいしそう。それ何ですか？<br>
            B: これ？作ったクッキー！ひとつどうですか？<br>
            A：あっ、どうもすみません。いただきます！<br>
            B：どうでしか？<br>
            A：めっちゃおいしいですよ！<br>',
        ];

        // Cau 2
        $content2 = [];
        $content2[1] = [
            'A: YUKAchan! Hôm nay có gì đó khác khác nhỉ! <br><br>
            B: Hể? Vậy sao? <br><br>
            A: UH. A không. Hoàn toàn khác… <br><br>
            B: Thật ra, hôm nay, có hẹn hò đấy! Mong chờ quá đây nè!!! <br><br>
            A: Ô vậy à! Hay nhỉ! Phải cái anh Giám đốc bên xí nghiệp IT đấy không? <br><br>
            B: Đúng, đúng, đúng! Vừa hào hoa, vừa thông minh… Kiểu người thật tuyệt!!! <br><br>
            A: Hay quá nhỉ! Ghen tỵ quá đi! <br><br>'
        ];

        $content2[2] = [
            'A: Uống đi, uống đi <br><br>
			    Chết tiệt! Con bồ nó cắm sừng tôi!<br><br>
            B: Hiểu mà..Hiểu mà…Thôi… <br><br>
            A: Hôm nay cùng uống đến sáng luôn!!!<br><br>
            B: Hả ? Vậy kế hoạch ngày mai thì sao?<br><br>
			   Mai chả phải đi sớm hay sao?<br><br>
            A: Đủ rồi đấy! Quên chuyện ngày mai đi!<br><br>
            B: Không sao chứ?!?<br><br>
            A: UH. Chết tiệt! <br><br>'
        ];

        $content2[3] = [
            'A: ...Vậy, tôi xin phép về trước ạ!<br><br>
            B: Ơ? Về đó hả?<br><br>
            A: Vâng!<br><br>
            B: Sau đây mọi người cùng đi uống đấy!<br><br>
			A: Vậy à! Hôm nay tình trạng sức khỏe tôi có chút…<br><br>
            B: Chị nói gì thế...?<br><br>
			   Chả phải từ nãy giờ chị toàn nhìn vô điện thoại, và cười suốt hay sao?<br><br>
            A: .........<br><br>'
        ];

        $content2[4] = [
            'A: ...Vậy, tôi xin phép về trước ạ!<br><br>
            B: Ơ? Về đó hả?<br><br>
            A: Vâng!<br><br>
            B: Sau đây mọi người cùng đi uống đấy!<br><br>
			A: Vậy à! Hôm nay tình trạng sức khỏe tôi có chút…<br><br>
            B: Chị nói gì thế...?<br><br>
			   Chả phải từ nãy giờ chị toàn nhìn vô điện thoại, và cười suốt hay sao?<br><br>
            A: .........<br><br>'
        ];

        $content2[5] = [
            'A: YOSHIDA KUN! Hôm nay bầu không khí có gì đó khác khác nhỉ!<br><br>
            B: Hể? Vậy sao? <br><br>
            A: UH. A không. Hoàn toàn khác…<br><br>
            B: Thật ra, hôm nay, có hẹn hò đấy! Mong chờ quá đây nè!!! <br><br>
            A: Ô vậy à! Hay nhỉ!<br><br>
			   A…Phải cô trưởng phòng bên ngân hàng APPURU đấy không?<br><br>
            B: Đúng, đúng, đúng! Vừa dịu dàng, vừa thông minh… Kiểu người thật tuyệt!!!<br><br>
            A: Hay quá nhỉ! Ghen tỵ quá đi!<br><br>'
        ];

        $content2[6] = [
            'A: Uống đi, uống đi <br><br>
			    Chết tiệt! Con bồ nó cắm sừng tôi!<br><br>
            B: Hiểu mà..Hiểu mà…Thôi… <br><br>
            A: Hôm nay cùng uống đến sáng luôn!!!<br><br>
            B: Hả ? Vậy kế hoạch ngày mai thì sao?<br><br>
			   Mai chả phải đi sớm hay sao?<br><br>
            A: Đủ rồi đấy! Quên chuyện ngày mai đi!<br><br>
            B: Không sao chứ?!?<br><br>
            A: UH. Chết tiệt! <br><br>'
        ];

        $content2[7] = [
            'A: ...Vậy, tôi xin phép về trước ạ!<br><br>
            B: Ơ? Về đó hả?<br><br>
            A: Vâng!<br><br>
            B: Sau đây mọi người cùng đi uống đấy!<br><br>
			A: Vậy à! Hôm nay tình trạng sức khỏe tôi có chút…<br><br>
            B: Chị nói gì thế...?<br><br>
			   Chả phải từ nãy giờ chị toàn nhìn vô điện thoại, và cười suốt hay sao?<br><br>
            A: .........<br><br>'
        ];

        // Cau 3
        $content3 = ['phase1_3_1.ogg', 'phase1_3_2.ogg', 'phase1_3_3.ogg'];

        // Cau 4
        $content4 = 'Bạn hãy tự phát họa cuộc đàm thoại giữa bạn và 1 nhân vật nào đó theo chủ đề sau: <br><br>
            “Bạn nhận được kết quả báo đậu trong kỳ thi tiếng Nhật JLPT, bạn hãy KHOE kết quả thi với họ” <br><br>
            (VD: Bạn trò chuyện với bạn thân, người trong gia đình, người yêu, giáo viên chủ nhiệm…) <br><br>
            *Yêu cầu đề bài:  <br><br>
            1/ Cuộc hội thoại giữa 2 nhân vật tối thiểu phải từ 5 câu trở lên.  <br><br>
            2/ Khi trình bày, bạn cần biểu đạt được cảm xúc của nhân vật trong lời thoại. <br><br>';
            
            // $content4 = 'Bạn hãy tự phát họa cuộc đàm thoại giữa bạn và 1 nhân vật nào đó theo chủ đề sau: <br><br>
            // 話題：パートナー、親友、仕事関係者など、信頼している人に裏切られました。誰かにそんなことを語ります。何と言いますか？会話しましょう‼<br><br>
            // (VD: Bạn trò chuyện với bạn thân, người trong gia đình, người yêu, giáo viên chủ nhiệm…) <br><br>
            // *Yêu cầu đề bài:  <br><br>
            // 1/ Cuộc hội thoại giữa 2 nhân vật tối thiểu phải từ 5 câu trở lên.  <br><br>
            // 2/ Khi trình bày, bạn cần biểu đạt được cảm xúc của nhân vật trong lời thoại. <br><br>';

        // for($core = 1; $core <= 5; $core++){
            $core = 1; // khoa thi dot 1
            for($code_test = 1; $code_test <= 7; $code_test++){
                $test = Model\Test::where('core_id', $core)->where('code', 'M'.$code_test)->first();
                $group = Model\Group::where('test_id', $test->id)->orderBy('stt')->get();
                $stt1 = 1;
                $stt2 = 1;
                $stt3 = 1;
                $stt4 = 1;
                foreach($group as $key => $v) {
                    if ($v->stt == 1) {
                        foreach($content1[$code_test] as $key1 => $c) {
                            Model\Question::create([
                                'group_id' => $v->id,
                                'stt' => $stt1++,
                                'content' => $c
                            ]);
                        }
                    } else if ($v->stt == 2) {
                        foreach($content2[$code_test] as $key1 => $c) {
                            Model\Question::create([
                                'group_id' => $v->id,
                                'stt' => $stt2++,
                                'content' => $c
                            ]);
                        }
                    } else if ($v->stt == 3) {
                        foreach($content3 as $c) {
                            Model\Question::create([
                                'group_id' => $v->id,
                                'stt' => $stt3++,
                                'content' => $c,
                                'audio' => 1
                            ]);
                        }                        
                    } else {
                        Model\Question::create([
                            'group_id' => $v->id,
                            'stt' => $stt4++,
                            'content' => $content4
                        ]);
                    }
                }
            }
        // }
    }
}
