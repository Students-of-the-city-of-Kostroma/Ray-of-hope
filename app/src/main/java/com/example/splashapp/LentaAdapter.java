package com.example.splashapp;

import android.content.Context;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import com.squareup.picasso.Picasso;

import java.util.ArrayList;
import java.util.List;

public class LentaAdapter extends RecyclerView.Adapter<LentaAdapter.ViewHolder>  {

    private List<M_Activism> Post;
    private List<M_Activism> itemsCopy=new ArrayList<M_Activism>();
    private Context context;
    private LentaAdapter.ItemClickListener mClickListener;

    public LentaAdapter(Context context,List<M_Activism> Post)
    {
        this.Post=Post;
        this.context=context;
        itemsCopy.addAll(Post);
    }

    @Override
    public ViewHolder onCreateViewHolder(ViewGroup parent, int ViewType)
    {
        View v = LayoutInflater.from(parent.getContext())
                .inflate(R.layout.event_post,parent,false);
        return  new ViewHolder(v);
    }

    @Override
    public void onBindViewHolder(LentaAdapter.ViewHolder holder, int position) {
        M_Activism or=Post.get(position);
        holder.id=or.getId();
        holder.name.setText(or.getName());
        holder.date.setText(or.getDate().toString());
        holder.about.setText(or.getDescription());
        Picasso.get().load(R.mipmap.about_logo).into(holder.imageView);
    }

    @Override
    public int getItemCount() {
        return Post.size();
    }

    public void filter(String text) {
        Post.clear();
        if(text.isEmpty()){
            Post.addAll(itemsCopy);
        } else{
            text = text.toLowerCase();
            for(M_Activism item: itemsCopy){
                if(item.getName().toLowerCase().contains(text)){
                    Post.add(item);
                }
            }
        }
        notifyDataSetChanged();
    }

    public class ViewHolder extends RecyclerView.ViewHolder implements View.OnClickListener {
        public String id;
        public TextView date;
        public TextView about;
        public ImageView imageView;
        public TextView name;



        public ViewHolder (View itemView)
        {
            super(itemView);
            imageView =(ImageView) itemView.findViewById(R.id.imageView12);
            name=(TextView) itemView.findViewById(R.id.textView31);
            date=(TextView) itemView.findViewById(R.id.textView32);
            about=(TextView) itemView.findViewById(R.id.textView18);

            itemView.setOnClickListener(this);
        }
        @Override
        public void onClick(View view) {
            if (mClickListener != null) mClickListener.onItemClick(view, getAdapterPosition());
        }
    }

    public M_Activism getOrg(int id) {
        return Post.get(id);
    }

    public void setClickListener(LentaAdapter.ItemClickListener itemClickListener) {
        this.mClickListener = itemClickListener;
    }

    public interface ItemClickListener {
        void onItemClick(View view, int position);
    }
}
