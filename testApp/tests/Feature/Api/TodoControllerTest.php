<?php
/*課題*/
//テストを実施する場合"@test"もしくは関数名の初めに"test"をつけないと、テストを実施してくれない


namespace Tests\Feature\Api;

use App\Models\Todo;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TodoControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp():void
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function Todoの新規作成()
    {
        $params = [
            'title' => 'テスト:タイトル',
            'content' => 'テスト:内容'
        ];

        $res = $this->postJson(route('api.todo.create'), $params);
        $res->assertOk();
        $todos = Todo::all();

        $this->assertCount(1, $todos);

        $todo = $todos->first();

        $this->assertEquals($params['title'], $todo->title);
        $this->assertEquals($params['content'], $todo->content);

    }


    /**
     *  @test
     */
    public function Todoの新規作成が失敗() {
        $params = [
            //"title" => null
            "title" => "テスト:タイトル",
            //"content" => null
            "content" => 1
        ];

        $res = $this->postJson(route("api.todo.create"), $params);

        //422はリクエストはできているが意味が異なるためサーバが返すことが出来ない
        $res->assertStatus(422);
    }

    /**
     * @test
     */
     public function Todoのデータ照合処理() {

        //実際にデータベースに挿入するわけではないが、テスト入力値を作成
        $params = Todo::factory()->create([
            "title" => "テスト:タイトル", 
            "content" => "テスト:内容"
        ]);

        
        $res = $this->getJson(route("api.todo.edit", $params->id));

        $res->assertOk();

        //resのデータをjson形式で抽出
        $match = $res->json();

        $this->assertSame($params->title, $match["title"]);
        $this->assertSame($params->content, $match["content"]);
     }

     /**
      * @test
      */
      public function Todoのデータ照合処理失敗() {
        $params = Todo::factory()->create([
            "title" => "テスト:タイトル", 
            "content" => "テスト:内容"
        ]);

        //idは1～の数字を自動でつけているので、"+1"で$paramsではないidにする
        $res = $this->getJson(route("api.todo.edit", $params->id + 1));

        //404はページが存在しない
        $res->assertStatus(404);

      }


      /**
      * @test
      */
      public function Todoの更新処理() {
        $params = Todo::factory()->create([
            "title" => "テスト:タイトル",
            "content" => "テスト:内容"
        ]);

        $update = [
            "title" => "更新:タイトル",
            "content" => "更新:内容"
        ];

        //第2引数に更新後のデータを設定
        $res = $this->putJson(route("api.todo.update", $params->id), $update);
        $res->assertOk();

        $this->assertDatabaseHas("todos", $update);

      }

      /**
      * @test
      */
      public function Todoの更新でバリデーション失敗() {
        $params = Todo::factory()->create([
            "title" => "テスト:タイトル",
            "content" => "テスト:内容"
        ]);

        $update = [
            "title" => "テスト:タイトル",
            "content" => null
        ];

        //第2引数に更新後のデータを設定
        $res = $this->putJson(route("api.todo.update", $params->id), $update);
        $res->assertStatus(422);

      }


    /**
     * @test
     */
      public function Todoの削除処理() {

        $params = Todo::factory()->create([
            "title" => "テスト:タイトル",
            "content" => "テスト:内容"
        ]);

        $res = $this->deleteJson(route("api.todo.delete", $params->id));
        $res->assertOk();

        //->toarrayで$paramsを["title" => "", "content" => ""];の形に変換する
        $this->assertDatabaseMissing("todos", $params->toArray());
        
      }


    /**
     * @test
     */
    public function Todoの削除処理でデータがない場合() {

        $params = Todo::factory()->create([
            "title" => "テスト:タイトル",
            "content" => "テスト:内容"
        ]);

        //存在しないIDを作成
        $deleteData = 999;

        $res = $this->deleteJson(route("api.todo.delete", $deleteData));
        $res->assertStatus(404);
        
    }
    




}