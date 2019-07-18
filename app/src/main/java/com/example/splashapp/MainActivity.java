package com.example.splashapp;

import android.content.DialogInterface;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.content.Intent;
import 	android.net.ConnectivityManager;
import android.content.Context;
import android.net.NetworkInfo;

public class MainActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        OnlineChek();
    }

    protected  void OnlineChek()
    {
        if (isOnline()) {
            Intent intent = new Intent(this, Choice.class);
            startActivity(intent);
            finish();
        }
        else {AlertDialog.Builder builder = new AlertDialog.Builder(MainActivity.this);
            builder.setMessage("Нет подключения к сети")
                    .setCancelable(false)
                    .setNegativeButton("Повторить",
                            new DialogInterface.OnClickListener() {
                                public void onClick(DialogInterface dialog, int id) {
                                    dialog.cancel();
                                    OnlineChek();
                                }
                            });
            AlertDialog alert = builder.create();
            alert.show();}
    }


    protected boolean isOnline() {
        ConnectivityManager cm = (ConnectivityManager) getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo netInfo = cm.getActiveNetworkInfo();
        if (netInfo != null && netInfo.isConnected()) {
            return true;
        } else {
            return false;
        }
    }
}
