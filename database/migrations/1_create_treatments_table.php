<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('treatments', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->decimal('price_min', 12, 2)->nullable();
            $table->decimal('price_max', 12, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::enableForeignKeyConstraints();

        //Insert Treatments
        DB::table('treatments')
        ->insert([
            ['name' => 'Examination Fee','description'=>null, 'price_min' => 5000, 'price_max' => 10000,'created_at'=>now(),'updated_at'=>now()],
            ['name' => 'Dressing','description'=>null, 'price_min' => 3000, 'price_max' => 7000,'created_at'=>now(),'updated_at'=>now()],
            ['name' => 'Amalgam Filling','description'=>null, 'price_min' => 12000, 'price_max' => 20000,'created_at'=>now(),'updated_at'=>now()],
            ['name' => 'Glass lonomer Filling','description'=>null, 'price_min' => 10000, 'price_max' => 15000,'created_at'=>now(),'updated_at'=>now()],
            ['name' => 'Composite Filling','description'=>null, 'price_min' => 15000, 'price_max' => 25000,'created_at'=>now(),'updated_at'=>now()],
            ['name' => 'Inlay/Onlay','description'=>null, 'price_min' => 25000, 'price_max' => 30000,'created_at'=>now(),'updated_at'=>now()],
            ['name' => 'Pulp Capping','description'=>null, 'price_min' => 5000, 'price_max' => 7000,'created_at'=>now(),'updated_at'=>now()],
            ['name' => 'Pulpotomy','description'=>null, 'price_min' => 12000, 'price_max' => 20000,'created_at'=>now(),'updated_at'=>now()],
            ['name' => 'RCT (Single Root)','description'=>null, 'price_min' => 30000, 'price_max' => 40000,'created_at'=>now(),'updated_at'=>now()],
            ['name' => 'RCT (2-Roots)','description'=>null, 'price_min' => 50000, 'price_max' => 60000,'created_at'=>now(),'updated_at'=>now()],
            ['name' => 'RCT (3 or 4 Roots)','description'=>null, 'price_min' => 65000, 'price_max' => 80000,'created_at'=>now(),'updated_at'=>now()],
            ['name' => 'Extraction','description'=>null, 'price_min' => 10000, 'price_max' => 15000,'created_at'=>now(),'updated_at'=>now()],
            ['name' => 'Impacted Tooth Extraction','description'=>null, 'price_min' => 35000, 'price_max' => 50000,'created_at'=>now(),'updated_at'=>now()],
            ['name' => 'Dry Socket Management','description'=>null, 'price_min' => 7000, 'price_max' => 8000,'created_at'=>now(),'updated_at'=>now()],
            ['name' => 'Post Operative Bleeding Mx','description'=>null, 'price_min' => 12000, 'price_max' => 15000,'created_at'=>now(),'updated_at'=>now()],
            ['name' => 'Scaling & Polishing','description'=>null, 'price_min' => 20000, 'price_max' => 40000,'created_at'=>now(),'updated_at'=>now()],
            ['name' => 'Periodontal Surgery','description'=>null, 'price_min' => 40000, 'price_max' => 50000,'created_at'=>now(),'updated_at'=>now()],
            ['name' => 'Operculectomy','description'=>null, 'price_min' => 25000, 'price_max' => 30000,'created_at'=>now(),'updated_at'=>now()],
            ['name' => 'Skyce (Diamond)','description'=>null, 'price_min' => 30000, 'price_max' => 40000,'created_at'=>now(),'updated_at'=>now()],
            ['name' => 'Teeth Whitening','description'=>'D/P on material', 'price_min' => 60000, 'price_max' => 80000,'created_at'=>now(),'updated_at'=>now()],
            ['name' => 'Jacket Crown (Acrylic)','description'=>null, 'price_min' => 40000, 'price_max' => 50000,'created_at'=>now(),'updated_at'=>now()],
            ['name' => 'Jacket Crown (Porcelain)','description'=>null, 'price_min' => 100000, 'price_max' => 150000,'created_at'=>now(),'updated_at'=>now()],
            ['name' => 'Jacket Crown (Zirconia)','description'=>null, 'price_min' => 150000, 'price_max' => 200000,'created_at'=>now(),'updated_at'=>now()],
            ['name' => 'Jacket Crown (E-Max)','description'=>null, 'price_min' => 150000, 'price_max' => 200000,'created_at'=>now(),'updated_at'=>now()],
            ['name' => 'Jacket Crown (Gold)','description'=>null, 'price_min' => 25000, 'price_max' => 30000,'created_at'=>now(),'updated_at'=>now()],
            ['name' => 'Jacket Crown (NPG)','description'=>null, 'price_min' => 40000, 'price_max' => 50000,'created_at'=>now(),'updated_at'=>now()],
            ['name' => 'Jacket Crown (Ni Cr)','description'=>null, 'price_min' => 40000, 'price_max' => 50000,'created_at'=>now(),'updated_at'=>now()],
            ['name' => 'Jacket Crown (Porcelain)','description'=>null, 'price_min' => 100000, 'price_max' => 150000,'created_at'=>now(),'updated_at'=>now()],
            ['name' => 'Denture-Full/Full (Acrylic)','description'=>'Japan', 'price_min' => 240000, 'price_max' => 300000,'created_at'=>now(),'updated_at'=>now()],
            ['name' => 'Denture-Full/Full (Skeletal)','description'=>null, 'price_min' => 450000, 'price_max' => 500000,'created_at'=>now(),'updated_at'=>now()],
            ['name' => 'Denture-Spoon (Acrylic)','description'=>'Japan', 'price_min' => 30000, 'price_max' => 50000,'created_at'=>now(),'updated_at'=>now()],
            ['name' => 'Denture-Spoon(Flexible)','description'=>null, 'price_min' => 40000, 'price_max' => 60000,'created_at'=>now(),'updated_at'=>now()],
            ['name' => 'Denture-P/D (Acrylic)/Unit','description'=>'Japan','price_min' => 20000, 'price_max' => 30000,'created_at'=>now(),'updated_at'=>now()],
            ['name' => 'Denture-P/D(Flexible)/Unit','description'=>null, 'price_min' => 30000, 'price_max' => 50000,'created_at'=>now(),'updated_at'=>now()],
            ['name' => 'Occlusal Grinding','description'=>null, 'price_min' => 3000, 'price_max' => 5000,'created_at'=>now(),'updated_at'=>now()],
            ['name' => 'Space Maintainer','description'=>null, 'price_min' => 40000, 'price_max' => 50000,'created_at'=>now(),'updated_at'=>now()],
            
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treatments');
    }
};
