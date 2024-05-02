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
            $table->decimal('price_min', 10, 2)->nullable();
            $table->decimal('price_max', 10, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::enableForeignKeyConstraints();

        //Insert Treatments
        DB::table('treatments')
        ->insert([
            ['name' => 'Examination Fee','description'=>null, 'price_min' => 5000, 'price_max' => 10000],
            ['name' => 'Dressing','description'=>null, 'price_min' => 3000, 'price_max' => 7000],
            ['name' => 'Amalgam Filling','description'=>null, 'price_min' => 12000, 'price_max' => 20000],
            ['name' => 'Glass lonomer Filling','description'=>null, 'price_min' => 10000, 'price_max' => 15000],
            ['name' => 'Composite Filling','description'=>null, 'price_min' => 15000, 'price_max' => 25000],
            ['name' => 'Inlay/Onlay','description'=>null, 'price_min' => 25000, 'price_max' => 30000],
            ['name' => 'Pulp Capping','description'=>null, 'price_min' => 5000, 'price_max' => 7000],
            ['name' => 'Pulpotomy','description'=>null, 'price_min' => 12000, 'price_max' => 20000],
            ['name' => 'RCT (Single Root)','description'=>null, 'price_min' => 30000, 'price_max' => 40000],
            ['name' => 'RCT (2-Roots)','description'=>null, 'price_min' => 50000, 'price_max' => 60000],
            ['name' => 'RCT (3 or 4 Roots)','description'=>null, 'price_min' => 65000, 'price_max' => 80000],
            ['name' => 'Extraction','description'=>null, 'price_min' => 10000, 'price_max' => 15000],
            ['name' => 'Impacted Tooth Extraction','description'=>null, 'price_min' => 35000, 'price_max' => 50000],
            ['name' => 'Dry Socket Management','description'=>null, 'price_min' => 7000, 'price_max' => 8000],
            ['name' => 'Post Operative Bleeding Mx','description'=>null, 'price_min' => 12000, 'price_max' => 15000],
            ['name' => 'Scaling & Polishing','description'=>null, 'price_min' => 20000, 'price_max' => 40000],
            ['name' => 'Periodontal Surgery','description'=>null, 'price_min' => 40000, 'price_max' => 50000],
            ['name' => 'Operculectomy','description'=>null, 'price_min' => 25000, 'price_max' => 30000],
            ['name' => 'Skyce (Diamond)','description'=>null, 'price_min' => 30000, 'price_max' => 40000],
            ['name' => 'Teeth Whitening','description'=>'D/P on material', 'price_min' => 60000, 'price_max' => 80000],
            ['name' => 'Jacket Crown (Acrylic)','description'=>null, 'price_min' => 40000, 'price_max' => 50000],
            ['name' => 'Jacket Crown (Porcelain)','description'=>null, 'price_min' => 100000, 'price_max' => 150000],
            ['name' => 'Jacket Crown (Zirconia)','description'=>null, 'price_min' => 150000, 'price_max' => 200000],
            ['name' => 'Jacket Crown (E-Max)','description'=>null, 'price_min' => 150000, 'price_max' => 200000],
            ['name' => 'Jacket Crown (Gold)','description'=>null, 'price_min' => 25000, 'price_max' => 30000],
            ['name' => 'Jacket Crown (NPG)','description'=>null, 'price_min' => 40000, 'price_max' => 50000],
            ['name' => 'Jacket Crown (Ni Cr)','description'=>null, 'price_min' => 40000, 'price_max' => 50000],
            ['name' => 'Jacket Crown (Porcelain)','description'=>null, 'price_min' => 100000, 'price_max' => 150000],
            ['name' => 'Denture-Full/Full (Acrylic)','description'=>'Japan', 'price_min' => 240000, 'price_max' => 300000],
            ['name' => 'Denture-Full/Full (Skeletal)','description'=>null, 'price_min' => 450000, 'price_max' => 500000],
            ['name' => 'Denture-Spoon (Acrylic)','description'=>'Japan', 'price_min' => 30000, 'price_max' => 50000],
            ['name' => 'Denture-Spoon(Flexible)','description'=>null, 'price_min' => 40000, 'price_max' => 60000],
            ['name' => 'Denture-P/D (Acrylic)/Unit','description'=>'Japan','price_min' => 20000, 'price_max' => 30000],
            ['name' => 'Denture-P/D(Flexible)/Unit','description'=>null, 'price_min' => 30000, 'price_max' => 50000],
            ['name' => 'Occlusal Grinding','description'=>null, 'price_min' => 3000, 'price_max' => 5000],
            ['name' => 'Space Maintainer','description'=>null, 'price_min' => 40000, 'price_max' => 50000],
            
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
