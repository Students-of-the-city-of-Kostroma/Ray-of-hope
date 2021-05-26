package com.example.splashapp;

import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.net.Uri;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;

import com.squareup.picasso.Picasso;

import java.io.FileNotFoundException;
import java.io.InputStream;
import java.text.SimpleDateFormat;
import java.util.Calendar;

public class AddPostActivity extends AppCompatActivity {

    ImageView imageView;
    Bitmap selectedImage;
    int photocounter=0;
    Bitmap[] bmp=new Bitmap[3];
    ImageView[] iv=new ImageView[3];
    final String DATE_FORMAT_NOW = "yyyy-MM-dd HH:mm:ss";
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_add_post);
        iv[0] = (ImageView) findViewById(R.id.p1);
        iv[1] = (ImageView) findViewById(R.id.p2);
        iv[2] = (ImageView) findViewById(R.id.p3);
    }

    public  void createPost(View view)
    {
        String[] input=new String[4];
        TextView textview= (TextView) findViewById(R.id.editText15);
        input[0]=textview.getText().toString();

        textview= (TextView) findViewById(R.id.editText16);
        input[1]=textview.getText().toString();

        Calendar cal = Calendar.getInstance();
        SimpleDateFormat sdf = new SimpleDateFormat(DATE_FORMAT_NOW);
        input[2]=sdf.format(cal.getTime());
        input[3]=C_Organization.MyOrg.getId();
        new Network().AddPost(input, bmp);
        finish();
    }

    public void AddPhoto(View view) {
        if (photocounter>2)
            return;
        Intent photoPickerIntent = new Intent(Intent.ACTION_PICK);
        photoPickerIntent.setType("image/*");
        startActivityForResult(photoPickerIntent, 0);
    }


    @Override
    protected void onActivityResult(int reqCode, int resultCode, Intent data) {
        super.onActivityResult(reqCode, resultCode, data);


        if (resultCode == -1) {
            try {
                final Uri imageUri = data.getData();
                final InputStream imageStream = getContentResolver().openInputStream(imageUri);
                bmp[photocounter] = BitmapFactory.decodeStream(imageStream);
                iv[photocounter].setImageBitmap(bmp[photocounter]);
                photocounter++;
            } catch (FileNotFoundException e) {
                e.printStackTrace();
            }
        }
    }

    public  void ToMyProf(View view)
    {
        boolean cit=Choice.citezen;
        if (cit) {
            Intent intent = new Intent(this, CitProf.class);
            startActivity(intent);
        }
        else { Intent intent = new Intent(this, MyOrgProf.class);
            startActivity(intent);}

        finish();
    }
    public  void openMenu(View view)
    {
        Intent intent = new Intent(this, MenuView.class);
        startActivity(intent);
        finish();
    }


    public  void ToListOfOrg(View view)
    {
        Intent intent = new Intent(this, ListOfOrg.class);
        startActivity(intent);
        finish();
    }
    public  void ToChat(View view)
    {
        Intent intent = new Intent(this, ThisChat.class);
        startActivity(intent);
    }
    public void ToLenta(View view)
    {
        Intent intent = new Intent(this, LentaActivity.class);
        startActivity(intent);
        finish();
    }
    public void ToChats(View view)
    {
        Intent intent = new Intent(this, ListOfChats.class);
        startActivity(intent);
        finish();
    }
}