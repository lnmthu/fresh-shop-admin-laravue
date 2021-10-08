<?php

use Illuminate\Database\Seeder;
use App\Laravue\Models\BlogItem;

class BlogItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('blog_items')->insert([
            [
                'title' => "Hướng dẫn làm món bánh quy bơ ngọt ngào bằng bơ làm bánh",
                'description' => "Vậy thì giờ đây, bạn sẽ không còn phải lo lắng nữa với công thức làm món bánh quy bơ thơm ngon từ Pháp nhé. Và tôi muốn chia sẻ công thức làm bánh quy sô cô la tuyệt vời này của Alison Roman, món đã được yêu thích nhanh chóng trong gia đình tôi.",
                'blog_category_id'=>"1",
                'user_id'=>"1",
                'body'=>"Tuần trước chúng tôi đã nghỉ làm, nhưng đã có rất nhiều bạn bè bay từ nước ngoài đến, các chi tiết về đám cưới vào phút chót và chuẩn bị bánh - bởi vì vâng, tôi đang làm bánh của riêng mình!
                Tôi đã có một vài lần thực sự muốn có một ít bánh quy, vì vậy tôi đã đánh một mẻ lớn bánh mì ngắn này và cắt lát và nướng theo yêu cầu, điều này khiến cuộc sống trở nên thật dễ dàng.
                Tôi chỉ cần cho bạn biết một vài điều về công thức này. Thứ nhất, đây là một loại cookie bánh mì ngắn, không phải là một loại bánh quy sô cô la thông thường. Nó có nhiều hương vị bơ, tan chảy trong miệng, giống như những Thanh cà phê sô cô la Chip Espresso này hơn là một chiếc bánh quy sô cô la chip thông thường. Mặc dù vậy, điều này có nghĩa là những chiếc bánh quy này giữ được mùi tốt hơn - chúng vẫn giòn và có mùi bơ trên băng ghế dự bị trong vài ngày.",
                'sort'=>"1",
                'status'=>"1"

            ],
            [
                'title' => "Bò Cuộn Phô Mai Mozzarella Đã Cơn Thèm",
                'description' => "Được biết đến như là một nguồn nguyên liệu đến từ quốc gia trứ danh với các món ăn ẩm thực nghệ thuật sang trọng của nước Ý, Phô Mai Mozzarella được lựa giới chuyên gia cũng như các đầu bếp hàng đầu thế",
                'blog_category_id'=>"1",
                'user_id'=>"1",
                'body'=>"Sau khi đã chuẩn bị đầy đủ nguyên liệu, bạn tiến hành lần lượt theo các bước sau:

                Bước 1: Rã đông đối với thịt bò đông lạnh và rửa sạch để ráo nước. Để không bị làm mất chất của thịt bò, bạn rửa sạch và vẩy để nhanh khô nước thay vì để ráo tự nhiên. Khai thái lát, bạn chú ý vừa miếng ăn hoặc có thể thái dạng sợi dài tầm 5 - 10cm tùy sở thích.

                Trứng bạn đánh tan vào bát và có thể cho thêm chút muối nếu bạn thích ăn đặm hoặc có thể không để lát chấm tương cũng là một cách hay để tăng thêm phần hấp dẫn cho món ăn.

                Bước 2: Cho phô mai vào giữa miếng thịt bò và cuộn nhẹ tay nhưng làm sao để kín, không bị bung nát. Bạn có thể yêu cầu nơi Bán Phô Mai bào mỏng thay vì mình tự làm sẽ nhìn đẹp mặt và đều hơn rất nhiều. Để không bị bung thì bạn nên sử dụng tăm tre để ghim lại cho chắc chắn mà vẫn đảm bảo an toàn vệ sinh thực phẩm.

                Bước 3: 'Tắm bột' miếng thịt đã cuộn với bột chiên xù sao cho lợp bột phủ kín miếng thịt. Tuy nhiên, nếu bạn thích ăn nhiều bột thì nên để miếng thịt ướt một chút để có thể dính được nhiều bột hơn nhé.

                Bước 4: Cho dầu vào chảo và chờ dầu nóng đều và cho thịt đã tẩm bột vào. Bạn nên cho nhẹ tay để tránh bị bung nhé. Cho nhỏ lửa vừa đủ để không làm cháy bột. Khi bột vàng cũng là lúc thịt bò bên trong đã chín, bạn có thể vớt ra đĩa. Để không có cảm giác ngậy của dầu mỡ, bạn nên lót phía dưới đĩa một lớp dấy ăn để rút mỡ hết trong miếng bò cuộn phô mai nhé.

                Bước 5: Rút toàn bộ tăm tre đã ghim và trình bày ra đĩa và mời mọi người thưởng thức.",
                'sort'=>"1",
                'status'=>"1"

            ],
            [
                'title' => " Thịt bò xào thế nào cho ngon mà không mất chất",
                'description' => "Thịt bò xào thế nào cho ngon mà không mất chất hiện đang được rất nhiều người làm nội trợ tìm kiếm để cải thiện bữa ăn gia đình đảm bảo dinh dưỡng. Trong bài viết này, Good Market sẽ hướng dẫn những cách",
                'blog_category_id'=>"1",
                'user_id'=>"1",
                'body'=>"Thông thường, người tiêu dùng khi đi chợ mua thịt bò ở Việt Nam vẫn còn nhiều người mua ở ngoài chợ truyền thống. Thế nhưng, với sự phát triển cũng như thời gian vừa qua rất nhiều trường hợp ngộ độc thực phẩm thịt bò vì sử dụng không rõ nguồn gốc đã khiến cho không ít người ái ngại. Đặc biệt, với những người nội trợ mong muốn mang lại sức khỏe đảm bảo cho gia đình.

                Dù ăn gì, mua ở đâu đi chăng nữa thì điều cốt lõi cũng chỉ là làm sao có bữa ăn ngon với chi phí thấp nhất mà vẫn đảm bảo sức khỏe cho cả nhà. Vì thế, việc đầu tiên mà mình muốn nói đến chính là lựa chọn nơi mua thực phẩm thịt bò uy tín và chất lượng. Hiện nay, đã và đang có rất nhiều hệ thống bán thịt bò chất lượng cả hàng nội địa và bò nhập khẩu, tùy vào nhu cầu của người tiêu dùng.

                Nếu quý khách thích ăn thịt bò ta thì nên lựa chọn những nơi bán thịt bò không bị ngâm nước. Dấu hiện dễ nhận thấy nhất đối với các loại thịt bò ngâm nước là sẽ thấy giọt nước ngay ở phần cuối cùng của miếng thịt bò khi được treo trên giá. Ngoài ra, với những loại thịt bò ngâm nước thì chắc chắn nấu sẽ không ngon, ăn cảm giác rất bở vì chúng bị ngâm nước hoặc bơm nước vào đã lâu khiến cho các thớ thịt bị bở ra không còn đảm bảo được độ săn chắc vốn có của thịt bò.",
                'sort'=>"1",
                'status'=>"1"

            ],
            [
                'title' => "Cách làm món bò bít tết ngay tại nhà hảo hạng",
                'description' => "Hướng dẫn làm món bò bít tết ngon ngay tại nhà với những nguyên liệu được cung cấp tại hệ thống siêu thị Good Market hoàn toàn sạch và được nhập khẩu, đảm bảo chất lượng.",
                'blog_category_id'=>"1",
                'user_id'=>"1",
                'body'=>"Rửa sạch thịt bò với nước và cho vào ngăn đá khoảng 15 - 20 phút để tạo khuôn hình phẳng làm cho miếng thịt nhìn bằng và dễ cắt hơn. Không nên để quá cứng vì sẽ làm cho việc cắt thái trở nên khó khăn hơn. Thông thường mình thường làm là, rửa sạch và cho vào tủ, đi nhặt rau và sơ chế các gia vị xong quay lại lấy thịt từ tủ ra là vừa.

                Lưu ý khi mua thịt: Để làm món bít tết ngon thì việc lựa chọn nguyên liệu ra rất quan trọng, quyết định đến 90% chất lượng món ăn có ngon và đạt tiêu chuẩn hay không. Vì thế, nếu không có kinh nghiệm chọn thịt bò thì nên nhờ người bán và nên các địa chỉ uy tín để mua thay vì mua hàng chợ. Một gợi ý nhỏ là ghé Good Market hoặc gửi thông tin cho Good Market về số lượng người ăn để được nhân viên tư vấn và lựa chọn thịt đúng chuẩn làm món bò bít tết nhé.

                Sau khi thịt đã sẵn sàng chế biến, hãy đặt miếng thịt lên thớt phẳng và đủ lớn để có thể dễ dàng cắt thái mà không bị rơi ra ngoài. Hãy cắt lát miếng dày khoảng 1 - 1,5cm tùy vào sở thích. Chú ý cắt theo phương vuông góc với thớ thịt để khi ăn không bị dai nhé.",
                'sort'=>"1",
                'status'=>"1"

            ],
            [
                'title' => "Vì sao bưởi thường được ăn vào dịp Trung thu?",
                'description' => "Bưởi có hình cầu tượng trưng cho trăng tròn và có phát âm giống với từ 'chúc phúc' trong tiếng Trung Quốc. Nhắc đến dịp lễ Halloween nổi tiếng của phương Tây, ta nghĩ ngay đến những quả bí ngô và những món ăn được làm từ loại quả này. Còn ở một số nước ...",
                'blog_category_id'=>"2",
                'user_id'=>"1",
                'body'=>"

                Bưởi Tân Triều

                Bưởi là một trong những loại thực phẩm gắn liền với lễ hội này, do có mùa thu hoạch trùng với mùa thu theo Âm lịch. Loại quả có vị chua ngọt, thanh nhẹ này xuất hiện ở các mâm cỗ và bàn thờ tổ tiên. Quả bưởi có hình cầu tượng trưng cho trăng tròn. Cách phát âm của từ “bưởi” trong tiếng Trung Quốc giống với từ “chúc phúc”. Vì vậy, người ta tin rằng ăn bưởi vào lễ hội này sẽ đem lại may mắn. Vào đêm Trung thu, người ta bày mâm cỗ gồm bưởi và bánh trung thu để dâng lên tổ tiên và nữ thần mặt trăng.

                Theo truyền thuyết của người Trung Quốc, bưởi là loại trái cây ưa thích của nữ thần mặt trăng Chang’e (hay Việt Nam còn gọi là Hằng Nga). Trong tiếng Quan Thoại, “bưởi” là một từ đồng âm với “cầu mong có con trai”. Vì vậy, tại đây, người ta tin rằng ăn bưởi và đội vỏ lên đầu sẽ khiến Hằng Nga nhìn thấy họ và đáp lại lời cầu nguyện. Tại tỉnh Quý Châu (Trung Quốc), người ta tin rằng ăn bưởi bằng cách cắt theo kiểu “giết bưởi” và lột vỏ có tác dụng xua đuổi năng lượng tiêu cực và tà ma.

                ",
                'sort'=>"1",
                'status'=>"1"

            ],
            [
                'title' => "Tác dụng của chanh dây sấy dẻo đến sức khỏe mà bạn nên biết",
                'description' => "Tác dụng của chanh dây sấy dẻo là gì? hay chanh dây sấy dẻo đem đến cho người sử dụng nhiều lợi ích cho sức khỏe",
                'blog_category_id'=>"2",
                'user_id'=>"1",
                'body'=>"Nguyên liệu:

                1 gói cà phê hòa tan

                200ml nước sôi

                8g bột gelatin

                150ml sữa tươi

                50g kem tươi (whipping cream)

                Một ít siro caramel

                Một ít chocolate",
                'sort'=>"1",
                'status'=>"1"

            ],
            [
                'title' => "Trái cây sấy lạnh là gì? Ưu và nhược điểm của phương pháp sấy lạnh",
                'description' => "Trái cấy sấy lạnh là gì? Chúng có gì đặc biệt mà lại thu hút khách hàng đến thế",
                'blog_category_id'=>"2",
                'user_id'=>"1",
                'body'=>"1.Trái cây sấy lạnh là gì?

                Trái cây sấy lạnh là sản phẩm sử dụng công nghệ sấy lạnh để là khô trái cây nhưng vẫn giữ được màu sắc tự nhiên, hương vị thơm ngon và đặc biệt là các hàm lượng chất dinh dưỡng có trong trái cây tươi. Chính vì vậy, đây là sự lựa chọn tuyệt vời trong việc bảo quản các loại nông sản trái cây sấy.
                2.Phương pháp sấy lạnh

                Với nguyên lý tách nước ra khỏi các sản phẩm cần sấy, chúng ta đều đã rất quen thuộc với các phương pháp sấy khô truyền thống. Tuy nhiên, một vấn đề đã nảy sinh là làm thế nào để các làm thế nào để giữ nguyện trọn vẹn những giá trị đinhưỡng của như màu sắc tự nhiên của sản phẩm. Và đó chính là lý do phương pháp sấy lạnh được ra đời như một giải pháp tối ưu cho vấn đề này.",
                'sort'=>"1",
                'status'=>"1"

            ],
            [
                'title' => "Hướng dẫn cách làm chè xoài trân châu lá dứa tuyệt ngon",
                'description' => "Trân châu lá dứa (bước này lâu nhất các chị có thể làm nhiều 1 lần rồi cất tủ đá, ăn tới đâu luộc tới đó để trân châu không bị bở mất độ dai) : lá dứa cắt ngắn cho vào máy xay sinh tố xay nhuyễn, lọc lấy nước cốt qua rây.",
                'blog_category_id'=>"3",
                'user_id'=>"1",
                'body'=>"Nguyên liệu làm chè xoài trân châu lá dứa:

                3 quả xoài chín gọt vỏ bỏ hạt

                0,5 gói bột trân châu khô (bột báng)

                100ml sữa tươi có đường

                3 thìa sữa đặc

                Cùi dừa thái nhỏ hạt lựu làm nhân của trân châu

                Đường cát trắng

                1 lon nước cốt dừa nhỏ

                1 gói bột năng

                Lá dứa",
                'sort'=>"1",
                'status'=>"1"

            ],
            [
                'title' => "Công thức mới làm thạch lá dứa vừa nhanh vừa ngon tới không ngờ",
                'description' => "Thạch lá dứa thanh thanh cực kì hợp cho ngày hè nắng lửa. Nguyên liệu: 3 thìa cafe bột rau câu con cá dẻo 6 thìa súp đường 8 lá dứa 200ml nước cốt dừa 500ml nước lọc 1 chút muối Cách làm:",
                'blog_category_id'=>"3",
                'user_id'=>"1",
                'body'=>"Nguyên liệu:

                3 thìa cafe bột rau câu con cá dẻo

                6 thìa súp đường

                8 lá dứa

                200ml nước cốt dừa

                500ml nước lọc

                1 chút muối",
                'sort'=>"1",
                'status'=>"1"

            ],
            [
                'title' => "Món thạch mang vị béo ngậy của kem sữa thơm lừng mùi cà phê",
                'description' => "Hãy nhanh chóng tham khảo cách làm thạch cà phê sữa mát lạnh để chiêu đãi cả nhà ngay nhé! Nguyên liệu: 1 gói cà phê hòa tan 200ml nước sôi 8g bột gelatin 150ml sữa tươi 50g kem tươi (whipping cream) Một ít siro caramel Một ít chocolate ",
                'blog_category_id'=>"3",
                'user_id'=>"1",
                'body'=>"Nguyên liệu:

                1 gói cà phê hòa tan

                200ml nước sôi

                8g bột gelatin

                150ml sữa tươi

                50g kem tươi (whipping cream)

                Một ít siro caramel

                Một ít chocolate",
                'sort'=>"1",
                'status'=>"1"

            ]

        ]);
    }
}
