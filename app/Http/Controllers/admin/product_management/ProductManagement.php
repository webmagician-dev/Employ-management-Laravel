<?php

namespace App\Http\Controllers\admin\product_management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;

class ProductManagement extends Controller
{
  public function index()
  {
    $productlist = Product::all();
    return view('admin.product-management.product-management', [
      'productlist' => $productlist,
    ]);
  }

  public function add()
  {
    return view('admin.product-management.product-add');
  }

  public function save(Request $request)
  {
    //Validate the form data
    $request->validate([
      'productname' => 'required|string|max:255',
      'price' => 'required|string|max:255',
      'file' => 'nullable|file|mimes:jpg,jpeg,png,gif',
    ]);

    // Process file upload if there is a file
    if ($request->hasFile('file')) {
      $file = $request->file('file');

      if ($file->isValid()) {
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('uploads/products', $fileName, 'public');
      } else {
        echo 'Fail';
      }
    }
    // Save product data to the database
    $product = new Product();
    $product->name = $request->input('productname');
    $product->price = $request->input('price');
    $product->avatar = $filePath; // Save the file path
    $product->save();
    // Redirect with success message
    return redirect('/admin/setting/product/management')->with('success', 'Product created successfully!');
  }

  public function edit($id)
  {
    $product = Product::findOrFail($id);
    return view('admin.product-management.product-edit', ['product' => $product]);
  }

  public function update(Request $request)
  {
    $request->validate([
      'productname' => 'required|string|max:255',
      'price' => 'required|string|max:255',
      'file' => 'nullable|file|mimes:jpg,jpeg,png,gif',
    ]);

    // Retrieve the product by ID
    $product = Product::findOrFail($request->input('productid'));
    // Update product data
    $product->name = $request->input('productname');
    $product->price = $request->input('price');

    if ($request->hasFile('file')) {
      // Delete the old file if it exists
      if ($product->avatar) {
        Storage::disk('public')->delete($product->avatar);
      }

      // Store the new file and update the avatar field
      $filePath = $request->file('file')->store('uploads/products', 'public');
      $product->avatar = $filePath;
    }
    // Save the updated product information
    $product->save();

    // Redirect to the product settings page with a success message
    return redirect('/admin/setting/product/management')->with('success', 'Profile updated successfully!');
  }

  public function destroy($id)
  {
    $product = Product::find($id);

    if ($product) {
      $product->delete();
      return response()->json(['message' => 'Item deleted successfully.']);
    } else {
      return response()->json(['message' => 'Item not found.'], 404);
    }
  }
}
