<h1>تشفير ملف</h1>
<form method="POST" action="/encrypt" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file" required>
    <input type="password" name="password" placeholder="كلمة المرور" required>
    <button type="submit">تشفير</button>
</form>
