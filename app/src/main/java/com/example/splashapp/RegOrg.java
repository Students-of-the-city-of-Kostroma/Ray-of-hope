package com.example.splashapp;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;

public class RegOrg extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_reg_org);
    }

    public void EnterToOrg(View view)
    {
        Intent intent = new Intent(this, N_menu.class);
        startActivity(intent);
        finish();
    }
}
