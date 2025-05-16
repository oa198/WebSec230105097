<h1>decryption</h1>
<form method="POST" action="/decrypt" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">decryption</button>
</form>
