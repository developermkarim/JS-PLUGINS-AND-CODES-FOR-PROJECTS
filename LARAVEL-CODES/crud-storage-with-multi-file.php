<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use Carbon\Carbon;
use Faker\Provider\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    /* Refactoring Data */

    public function thumbnailStore($request)
    {
        //* thumbnail Image Process
        if($request->hasFile('thumbnail_name')){

            $extension = $request->thumbnail_name->extension();
            $image = str($request->title)->slug() . '-product.' . $extension;
           $image_path = $request->thumbnail_name->storeAs('product',$image,'public');
            $imageUri = env('APP_URL') . '/storage/' . $image_path;
    
    
            return ['thumb_name'=>$image,'thumbnail_uri'=> $imageUri];
        }
       
    }


    /* Thumbnail Image Gallery Refactoring */
    public function multiple_images($request, $productId)
    {
        $galleryImages = $request->file('product_gallery_images');
        foreach ($galleryImages as $gall_Img) {
            $extension = $gall_Img->extension();
                $gall_image = str($request->title)->slug() . uniqid().'-product.' . $extension;
               $image_path = $gall_Img->storeAs('product',$gall_image,'public');
                $gallery_uri = env('APP_URL') . '/storage/' . $image_path;
        
                $galleryImageStore = new ProductImage();
                $galleryImageStore->product_id = $productId;
                $galleryImageStore->product_name = $gall_image;
                $galleryImageStore->product_uri = $gallery_uri;
                $galleryImageStore->save();
            }

    }

   public function addProduct()
   {
    $categories = Category::select('id','title')->get();
    $brands = Brand::select('id','title')->get();
    // dd($categories);
    return view('backend.product.add',compact('categories','brands'));
   }

   /* This is for Subcategory in ajax */

   public function fetchSubcategory($id)
   {
   
    $sub_category = SubCategory::where('category_id',$id)->select('id','title')->get();
    if(count($sub_category) > 0){
        return $sub_category;
    }
    else{
        return 'No Subcategory is available';
    }
   
  
   }

   public function fetchSubSubcategory(Request $request)
   {
    $sub_category_id = $request->subSubCategory;

    $subSubcategories = SubSubCategory::where('sub_category_id',$sub_category_id)->select('id','title')->get();

    // dd($subSubcategories);
    if(count($subSubcategories) > 0){
        return response($subSubcategories);
    }
    else{
        return  "No Sub Sub-category is found";
    }

   }

   public function productStore(Request $request) 
   {

    // dd($request->all());
    // dd($request->product_multiple_images); 
  /*   $result = $this->thumbnailStore($request);
    dd($result);  */
    //   dd($request->all());
    // dd($request->slug ? str($request->slug)->slug() : str($request->title)->slug());
  
    //   dd($thumbnail);
    $product = new Product();
    $product->title = $request->title;
    $product->slug = $request->slug ? str($request->slug)->slug() : str($request->title)->slug();
    $product->price = $request->price;
    $product->discount_price = $request->discount_price;
    $product->qty = $request->product_qty;
    $product->tags = $request->products_tags;
    $product->sizes = $request->product_size;
    $product->colors = $request->product_color;
    $product->status = $request->stock;
    $product->category_id = $request->category;
    $product->sub_category_id = $request->subCategory;
    $product->sub_sub_category_id = $request->subSubCategory;
    $product->brand_id = $request->brand;
    $product->start_date = $request->start_date;
    $product->end_date = $request->end_date;
    $product->product_code = $request->product_code;
    $product->short_detail = $request->short_detail;
    $product->long_detail = $request->long_detail;


    $thumbnail = $this->thumbnailStore($request);
    if($request->hasFile('thumbnail_name')){
        $product->thumbnail_uri = $thumbnail['thumbnail_uri'];
        $product->thumbnail_name = $thumbnail['thumb_name'];
    };
   
  
    $product->hot_deals = $request->hot_deals;
    $product->featured = $request->featured;
    $product->special_offer = $request->special_offer;
    $product->special_deals = $request->special_deals;
    $product->video_uri = $request->video_uri;
   
   if(  $product->save()){
    $notification = [
        'message'=>'Product added successfully',
        'alert-type'=>'success',
    ];

    $this->multiple_images($request,$product->id);

   }

    return redirect()->route('product.all')->with($notification);

    } 


    public function allProduct ()
    {
        $products = Product::latest()->get();
       return view('backend.product.all_products',compact('products'));
    }


    public function editProduct(Product $editProduct)
    {
        $multiImgs = ProductImage::where('product_id',$editProduct->id)->get();
        $categories = Category::select('id','title')->get();
        $brands = Brand::select('id','title')->get();
       $subCategories = SubCategory::select('id','title')->get();
       $subSubCategories = subSubCategory::select('id','title')->get();
        return view('backend.product.edit_product',compact('editProduct','categories','brands','subCategories','subSubCategories','multiImgs'));
    }




    public function updateProduct(Request $request, Product $product)
    {

   
    //    dd($request->all());

    $product->title = $request->title;
    $product->slug = $request->slug ? str($request->slug)->slug() : str($request->title)->slug();
    $product->price = $request->price;
    $product->discount_price = $request->discount_price;
    $product->qty = $request->product_qty;
    $product->tags = $request->product_tags;
    $product->sizes = $request->product_size;
    $product->colors = $request->product_color;
    $product->status = $request->stock;
    $product->category_id = $request->category;
    $product->sub_category_id = $request->subCategory;
    $product->sub_sub_category_id = $request->subSubCategory;
    $product->brand_id = $request->brand;
    $product->start_date = $request->start_date;
    $product->end_date = $request->end_date;
    $product->product_code = $request->product_code;
    $product->short_detail = $request->short_detail;
    $product->long_detail = $request->long_detail;

    
    $path = 'product/'. $product->thumbnail_name;
    //  dd($path);
    if($request->hasFile('thumbnail_name')){

        if(Storage::disk('public')->exists($path)){
            Storage::disk('public')->delete($path);
        }

        $thumbnail = $this->thumbnailStore($request);
        $product->thumbnail_uri = $thumbnail['thumbnail_uri'];
        $product->thumbnail_name = $thumbnail['thumb_name'];

      
    };
   
  
    $product->hot_deals = $request->hot_deals;
    $product->featured = $request->featured;
    $product->special_offer = $request->special_offer;
    $product->special_deals = $request->special_deals;
    $product->video_uri = $request->video_uri;
    
if($product->update()){

    $notification = array(
        'message' => 'Product Updated Successfully',
        'alert-type' => 'success'
    );
}
else{
    $notification = array(
        'message' => 'SOrry,Product  was not Updated',
        'alert-type' => 'Error'
    );

}
    

    return redirect()->route('product.all')->with($notification);
}


/* Update updateMultiImage start  */
public function updateMultiImage(Request $request)
{
    $allImages = $request->multi_img;

    // dd($allImages);

    if($request->hasFile('multi_img')){
        foreach ($allImages as $key => $image) {
            // dd($key);
            $multiImages = ProductImage::findOrFail($key);
    
            $path = 'product/' . $multiImages->product_name;
            // dd($path);
            if(Storage::disk('public')->exists($path)){
                Storage::disk('public')->delete($path);
            }
            $imageExt = $image->extension();
            $imageName = 'multiImage-' . mt_rand(100,999) . '.' . $imageExt;
            $image_path = $image->storeAs('product/' , $imageName, 'public');
            $image_uri = env('APP_URL') . '/storage/'  . $image_path;
            // dd($image_uri);
    
            $multiImages->product_name = $imageName;
            $multiImages->product_uri = $image_uri;
            $multiImages->updated_at = Carbon::now();
            $multiImages->save();
        }

        $notification = array(
            'message'=>'Image not uploaded and Updated',
            'alert-type'=>'success',
        );

    }

    else{

        $notification = array(
            'message'=>'Image not uploaded',
            'alert-type'=>'warning',
        );

    }
   
    return redirect()->back()->with($notification);

    // return back();
}
/* Update updateMultiImage end */

/* delete updateMultiImage start */
public function deleteMultiImage($id)
{
   $result = ProductImage::findOrFail($id);
// dd($result->product_name );
$path = 'product/' . $result->product_name;
   if($result->delete()){

    if(Storage::disk('public')->exists($path)){
        Storage::disk('public')->delete($path);
    }
   
    $notification = array(
        'message'=>'Image deleted from multiImage table',
        'alert-type'=>'success',
    );

   }

   else{
    $notification = array(
        'message'=>'Image not deleted from multiImage table',
        'alert-type'=>'error',
    );

   }

   return redirect()->back()->with($notification);

}

/* delete updateMultiImage end */


    /* To change Product Status */

    public function statusProduct($status,$id)
    {
        $productStatus = Product::findOrFail($id);
        // dd($productStatus);
        $productStatus->status = $status;
        if($productStatus->save()){

            $notification = [
                'message'=>'Status Changed Successfully',
                'alert-type'=>'success',
            ];
        }

        return redirect()->route('product.all')->with($notification);
    }


    /* Product Delete  */

   public function deleteProduct(Product $product)
   {
    // dd($product->id);
    $multiImages = ProductImage::where('product_id', $product->id)->get();
    // dd($multiImages);

    foreach ($multiImages as $key => $value) {
       $path = 'product/' . $value->product_name;
       
       if(Storage::disk('public')->exists($path)){
         Storage::disk('public')->delete($path);

       }

    };

    $deleted = $product->delete();
    if($deleted){

        $notification = [
            'message'=>'Product Deleted successfully',
            'alert-type'=>'success',
        ];
       
    };

return redirect()->route('product.all')->with($notification);
   }



   }

  

