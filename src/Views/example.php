<div class="bg-slate-900 h-full text-slate-200 pt-16 px-64 text-lg">
    <div class="border-b pb-4 border-slate-800 mb-16 text-center">
        <h1 class="text-3xl font-semibold text-sky-500 mb-4">Your karma app is ready !</h1>
        <p>You're seeing this page, it means your karma app is working, now let's see how to use it: </p>
    </div>
    <div class="border rounded-lg p-4 border-slate-800 mb-16">
        <h2 class="text-2xl font-semibold text-sky-500 mb-4">Commands :</h2>
        <p>All the karma commands you want to run have to respect this structure <code class="bg-slate-800 p-1 rounded text-base">php karma &lt;command&gt;</code></p>
        <ul class="list-disc list-inside ml-6">
            <li><code class="bg-slate-800 p-1 rounded text-base">start &lt;port (default: 8000)&gt;</code> Runs your app</li>
            <li><code class="bg-slate-800 p-1 rounded text-base">create:&lt;type ([controller | manager | model | all] required)&gt; &lt;name&gt;</code> Creates a file with code preset, depends of the type you choose</li>
            <li><code class="bg-slate-800 p-1 rounded text-base">setup &lt;extension ([tailwind | fontawesome] optional)&gt;</code> Sets your app up, install deps, configures autoload, and add extensions you choose to your layout view</li>
        </ul>
    </div>

    <div class="border rounded-lg p-4 border-slate-800 mb-16">
        <h2 class="text-2xl font-semibold text-sky-500 mb-4">Get started :</h2>
        <p>To get started, run this command <code class="bg-slate-800 p-1 rounded text-base">php karma create:all <?php echo APP_NAME ?></code></p>
        <p>Then go to <code class="bg-slate-800 p-1 rounded text-base"><?php echo CONTROLLERS.APP_NAME."Controller.php" ?></code>, and you can start to edit your controller</p>
        <p>Same for manager <code class="bg-slate-800 p-1 rounded text-base"><?php echo MANAGERS.APP_NAME."Manager.php" ?></code></p>
        <p>And model <code class="bg-slate-800 p-1 rounded text-base"><?php echo MODELS.APP_NAME.".php" ?></code></p>
    </div>
</div>