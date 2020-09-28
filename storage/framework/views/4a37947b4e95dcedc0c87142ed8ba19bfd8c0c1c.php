<script>
var firebaseConfig = {
  apiKey: "<?php echo e(setting('firebase_api_key','')); ?>",
  authDomain: "<?php echo e(setting('firebase_auth_domain','')); ?>",
  databaseURL: "<?php echo e(setting('firebase_database_url','')); ?>",
  projectId: "<?php echo e(setting('firebase_project_id','')); ?>",
  storageBucket: "<?php echo e(setting('firebase_storage_bucket','')); ?>",
  messagingSenderId: "<?php echo e(setting('firebase_messaging_sender_id','')); ?>",
  appId: "<?php echo e(setting('firebase_app_id')); ?>",
  measurementId: "<?php echo e(setting('firebase_measurement_id','')); ?>"
};

// Initialize Firebase
firebase.initializeApp(firebaseConfig);
</script><?php /**PATH C:\xampp\htdocs\devtajeer-master\devtajeer\resources\views/vendor/notifications/init_firebase.blade.php ENDPATH**/ ?>