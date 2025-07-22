<form action="/zara/pdf/upload" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="text" name="title" placeholder="Tajuk dokumen" class="form-control my-2" required>
    <input type="file" name="pdf" class="form-control my-2" accept="application/pdf" required>
    <button class="btn btn-primary">Upload</button>
</form>
