<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Models\Book;
use OpenApi\Annotations as OA;
use Validator;

/**
 * Class BookController.
 * 
 * @author Billy <billy.422023018@civitas.ukrida.ac.id>
 */
class BookController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/book",
     *      tags={"book"},
     *      summary="Display a listing of items",
     *      operationId="index",
     *      @OA\Response(
     *          response="200",
     *          description="successful",
     *          @OA\JsonContent()
     *      )
     * )
     */
    public function index()
    {
        return Book::get();
    }

    /**
     * @OA\Post(
     *      path="/api/book",
     *      tags={"book"},
     *      summary="Store a newly created item",
     *      operationId="store",
     *      @OA\Response(
     *          response=400,
     *          description="Invalid input",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful",
     *          @OA\JsonContent()
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          description="Request body description",
     *          @OA\JsonContent(
     *              ref="#/components/schemas/Book",
     *              example={
     *                  "title": "Siti Nurbaya",
     *                  "author": "Marah Roesli",
     *                  "publisher": "MG",
     *                  "publication_year": "1922",
     *                  "cover": "https://id.images.search.yahoo.com/images/view;_ylt=Awr1TVUYEldmu50YHHnNQwx.;_ylu=c2VjA3NyBHNsawNpbWcEb2lkA2UzZTA4MTMyNjE5MWFlOGY2NzdiMGI0OTI2MTM5NzMxBGdwb3MDMTEEaXQDYmluZw--?back=https%3A%2F%2Fid.images.search.yahoo.com%2Fsearch%2Fimages%3Fp%3DSITI%2BNURBAYA%2BBOOK%2BCOVERE%26type%3DE210ID91215G0%26fr%3Dmcafee%26fr2%3Dpiv-web%26tab%3Dorganic%26ri%3D11&w=316&h=475&imgurl=i.gr-assets.com%2Fimages%2FS%2Fcompressed.photo.goodreads.com%2Fbooks%2F1325137737l%2F13333419.jpg&rurl=https%3A%2F%2Fkabarmedia.github.io%2Fkelebihan-dan-kekurangan-novel-siti-nurbaya%2F&size=48.7KB&p=SITI+NURBAYA+BOOK+COVERE&oid=e3e081326191ae8f677b0b4926139731&fr2=piv-web&fr=mcafee&tt=Kelebihan+Dan+Kekurangan+Novel+Siti+Nurbaya+%E2%80%93+kabarmedia.github.io&b=0&ni=21&no=11&ts=&tab=organic&sigr=0CPhUoNuvJ67&sigb=dp_JNP7aZEDA&sigi=vQi7t2VtHazU&sigt=.15BDFmgpc7g&.crumb=5OHK9wpKdN5&fr=mcafee&fr2=piv-web&type=E210ID91215G0",
     *                  "description": "Novel ini menceritakan kisah tragis cinta antara Siti Nurbaya dan Samsulbahri. Siti Nurbaya adalah seorang gadis muda yang cantik dan berbudi luhur dari keluarga sederhana. Ia jatuh cinta dengan Samsulbahri, teman masa kecilnya yang juga mencintainya. Namun, cinta mereka terhalang oleh adat dan tekanan sosial.",
     *                  "price": 72.500}
     *          ),
     *      ),
     *  security={{"passport_token_ready":{},"passport":{}}}
     * )
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|unique:books',
                'author' => 'required|max:100',
            ]);

            if ($validator->fails()) {
                throw new HttpException(400, $validator->messages()->first());
            }

            $book = new Book;
            $book->fill($request->all())->save();
            return $book;

        } catch (\Exception $exception) {
            throw new HttpException(400, "Invalid data: {$exception->getMessage()}");
        }
    }

    /**
     * @OA\Get(
     *      path="/api/books/{id}",
     *      tags={"book"},
     *      summary="Display the specified item",
     *      operationId="show",
     *      @OA\Response(
     *          response=404,
     *          description="Item not found",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Invalid input",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID of item that needs to be displayed",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        $book = Book::find($id);
        if (!$book) {
            throw new HttpException(404, "Item not found");
        }
        return $book;
    }

    /**
     * @OA\Put(
     *      path="/api/books/{id}",
     *      tags={"book"},
     *      summary="Update the specified item",
     *      operationId="update",
     *      @OA\Response(
     *          response=404,
     *          description="Item not found",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Invalid input",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID of item that needs to be updated",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          description="Request body description",
     *          @OA\JsonContent(
     *              ref="#/components/schemas/Book",
     *              example={
     *                  "title": "Siti Nurbaya",
     *                  "author": "Marah Roesli",
     *                  "publisher": "MG",
     *                  "publication_year": "1922",
     *                  "cover": "https://id.images.search.yahoo.com/images/view;_ylt=Awr1TVUYEldmu50YHHnNQwx.;_ylu=c2VjA3NyBHNsawNpbWcEb2lkA2UzZTA4MTMyNjE5MWFlOGY2NzdiMGI0OTI2MTM5NzMxBGdwb3MDMTEEaXQDYmluZw--?back=https%3A%2F%2Fid.images.search.yahoo.com%2Fsearch%2Fimages%3Fp%3DSITI%2BNURBAYA%2BBOOK%2BCOVERE%26type%3DE210ID91215G0%26fr%3Dmcafee%26fr2%3Dpiv-web%26tab%3Dorganic%26ri%3D11&w=316&h=475&imgurl=i.gr-assets.com%2Fimages%2FS%2Fcompressed.photo.goodreads.com%2Fbooks%2F1325137737l%2F13333419.jpg&rurl=https%3A%2F%2Fkabarmedia.github.io%2Fkelebihan-dan-kekurangan-novel-siti-nurbaya%2F&size=48.7KB&p=SITI+NURBAYA+BOOK+COVERE&oid=e3e081326191ae8f677b0b4926139731&fr2=piv-web&fr=mcafee&tt=Kelebihan+Dan+Kekurangan+Novel+Siti+Nurbaya+%E2%80%93+kabarmedia.github.io&b=0&ni=21&no=11&ts=&tab=organic&sigr=0CPhUoNuvJ67&sigb=dp_JNP7aZEDA&sigi=vQi7t2VtHazU&sigt=.15BDFmgpc7g&.crumb=5OHK9wpKdN5&fr=mcafee&fr2=piv-web&type=E210ID91215G0",
     *                  "description": "Novel ini menceritakan kisah tragis cinta antara Siti Nurbaya dan Samsulbahri. Siti Nurbaya adalah seorang gadis muda yang cantik dan berbudi luhur dari keluarga sederhana. Ia jatuh cinta dengan Samsulbahri, teman masa kecilnya yang juga mencintainya. Namun, cinta mereka terhalang oleh adat dan tekanan sosial.",
     *                  "price": 72.500
     *              }
     *          ),
     *      ),
     *      security={{"passport_token_ready":{},"passport":{}}}
     * )
     */
    public function update(Request $request, $id)
    {
        $book = Book::find($id);
        if (!$book) {
            throw new HttpException(404, "Item not found");
        }

        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|unique:books',
                'author' => 'required|max:100',
            ]);

            if ($validator->fails()) {
                throw new HttpException(400, $validator->messages()->first());
            }

            $book->fill($request->all())->save();
            return response()->json(['message' => 'Updated successfully'], 200);

        } catch (\Exception $exception) {
            throw new HttpException(400, "Invalid data: {$exception->getMessage()}");
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/books/{id}",
     *      tags={"book"},
     *      summary="Remove the specified item",
     *      operationId="destroy",
     *      @OA\Response(
     *          response=404,
     *          description="Item not found",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Invalid input",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID of item that needs to be removed",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          ),
     *      ),
     *  security={{"passport_token_ready":{},"passport":{}}}
     * )
     */
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        if (!$book) {
            throw new HttpException(404, "Item not found");
        }

        try {
            $book->delete();
            return response()->json(['message' => 'Deleted successfully'], 200);

        } catch (\Exception $exception) {
            throw new HttpException(400, "Invalid data: {$exception->getMessage()}");
        }
    }
}